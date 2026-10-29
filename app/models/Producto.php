<?php
// MODELO: tabla "productos"
class Producto
{
    // Devuelve los productos agrupados: ["Hamburguesas" => [...], "Bebidas" => [...]]
    public static function disponiblesPorCategoria(): array
    {
        $conexion = Database::conectar();

        $resultado = $conexion->query(
            "SELECT id_producto, nombre, precio, categoria
             FROM productos
             WHERE disponible = 1
             ORDER BY categoria, nombre"
        );

        $categorias = [];

        while ($producto = $resultado->fetch_assoc()) {
            $categorias[$producto["categoria"]][] = $producto;
        }

        return $categorias;
    }

    // Busca un producto disponible (para leer su precio real desde la BD)
    public static function buscarDisponible(int $id): ?array
    {
        $conexion = Database::conectar();

        $stmt = $conexion->prepare(
            "SELECT nombre, precio
             FROM productos
             WHERE id_producto = ?
             AND disponible = 1"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $fila = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $fila ?: null;
    }
}

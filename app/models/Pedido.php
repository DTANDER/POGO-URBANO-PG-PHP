<?php
// MODELO: tablas "pedidos" y "detalle_pedido"
class Pedido
{
    /**
     * Valida los productos con los precios de la BD (nunca los del navegador)
     * y guarda el pedido + su detalle en una transacción.
     * Devuelve ["id_pedido" => ..., "total" => ...]
     * Si algo falla lanza una Exception con un mensaje para el cliente.
     */
    public static function crear(int $idUsuario, string $direccion, string $pago, array $items): array
    {
        $validos = [];
        $lineas  = [];
        $total   = 0;

        foreach ($items as $item) {

            $idProducto = intval($item["id"] ?? 0);
            $cantidad   = intval($item["cantidad"] ?? 0);

            if ($idProducto <= 0 || $cantidad <= 0 || $cantidad > 50) {
                continue;
            }

            $producto = Producto::buscarDisponible($idProducto);

            if (!$producto) {
                continue;
            }

            $precio   = floatval($producto["precio"]);
            $subtotal = $precio * $cantidad;

            $total += $subtotal;

            $lineas[]  = $cantidad . " x " . $producto["nombre"];
            $validos[] = [$idProducto, $cantidad, $precio, $subtotal];
        }

        if (empty($validos)) {
            throw new Exception("Los productos de tu carrito ya no están disponibles.");
        }

        $detalle  = implode("\n", $lineas);
        $conexion = Database::conectar();

        try {

            $conexion->begin_transaction();

            $estado = "Pendiente";

            $stmtPedido = $conexion->prepare(
                "INSERT INTO pedidos
                (id_usuario, fecha, total, estado, direccion, metodo_pago, detalle)
                VALUES (?, NOW(), ?, ?, ?, ?, ?)"
            );
            $stmtPedido->bind_param(
                "idssss",
                $idUsuario, $total, $estado, $direccion, $pago, $detalle
            );
            $stmtPedido->execute();

            $idPedido = $conexion->insert_id;

            $stmtDetalle = $conexion->prepare(
                "INSERT INTO detalle_pedido
                (id_pedido, id_producto, cantidad, precio, subtotal)
                VALUES (?, ?, ?, ?, ?)"
            );

            foreach ($validos as $fila) {
                [$idProducto, $cantidad, $precio, $subtotal] = $fila;

                $stmtDetalle->bind_param(
                    "iiidd",
                    $idPedido, $idProducto, $cantidad, $precio, $subtotal
                );
                $stmtDetalle->execute();
            }

            $conexion->commit();

            return ["id_pedido" => $idPedido, "total" => $total];

        } catch (Throwable $e) {

            $conexion->rollback();

            throw new Exception("No se pudo guardar el pedido. Intenta de nuevo.");
        }
    }
}

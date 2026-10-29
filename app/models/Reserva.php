<?php
// MODELO: tabla "reservas"
class Reserva
{
    // ¿Esa mesa ya está reservada en esa fecha y hora? (las canceladas no cuentan)
    public static function mesaOcupada(string $fecha, string $hora, int $mesa): bool
    {
        $conexion = Database::conectar();

        $stmt = $conexion->prepare(
            "SELECT id_reserva
             FROM reservas
             WHERE fecha = ?
             AND hora = ?
             AND mesa = ?
             AND estado != 'Cancelada'
             LIMIT 1"
        );
        $stmt->bind_param("ssi", $fecha, $hora, $mesa);
        $stmt->execute();

        $ocupada = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        return $ocupada;
    }

    // Guarda la reserva. Lanza mysqli_sql_exception si algo falla
    public static function crear(
        int $idUsuario,
        string $fecha,
        string $hora,
        int $personas,
        int $mesa,
        string $estado
    ): void {
        $conexion = Database::conectar();

        $stmt = $conexion->prepare(
            "INSERT INTO reservas
            (id_usuario, fecha, hora, personas, mesa, estado)
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ississ", $idUsuario, $fecha, $hora, $personas, $mesa, $estado);
        $stmt->execute();
        $stmt->close();
    }
}

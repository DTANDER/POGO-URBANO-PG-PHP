<?php
// Crea UNA sola conexión y la comparten todos los modelos
class Database
{
    private static ?mysqli $conexion = null;

    public static function conectar(): mysqli
    {
        if (self::$conexion === null) {
            $cfg = require __DIR__ . '/../config/config.php';

            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            self::$conexion = new mysqli(
                $cfg['host'], $cfg['usuario'], $cfg['password'],
                $cfg['nombre'], $cfg['puerto']
            );
            self::$conexion->set_charset('utf8mb4');
        }

        return self::$conexion;
    }
}

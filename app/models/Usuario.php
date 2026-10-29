<?php
// MODELO: lo único que sabe es hablar con la tabla "usuario"
class Usuario
{
    // Valor de la columna "rol" que identifica a un administrador (0 = cliente)
    const ROL_ADMIN = 1;

    public static function buscarPorCorreo(string $correo): ?array
    {
        $conexion = Database::conectar();

        $stmt = $conexion->prepare(
            "SELECT id_usuario, nombre, correo, contraseña, rol
             FROM usuario
             WHERE correo = ?"
        );
        $stmt->bind_param("s", $correo);
        $stmt->execute();

        $fila = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $fila ?: null;
    }

    public static function buscarPorId(int $id): ?array
    {
        $conexion = Database::conectar();

        $stmt = $conexion->prepare(
            "SELECT nombre, telefono
             FROM usuario
             WHERE id_usuario = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $fila = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $fila ?: null;
    }

    // Usuarios que ya usan ese correo O ese teléfono (para avisar de duplicados)
    public static function buscarPorCorreoOTelefono(string $correo, string $telefono): array
    {
        $conexion = Database::conectar();

        $stmt = $conexion->prepare(
            "SELECT id_usuario, correo, telefono
             FROM usuario
             WHERE correo = ? OR telefono = ?"
        );
        $stmt->bind_param("ss", $correo, $telefono);
        $stmt->execute();

        $filas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $filas;
    }

    // Guarda un usuario nuevo. Lanza mysqli_sql_exception si algo falla
    // (por ejemplo código 1062 = correo o teléfono repetido)
    public static function crear(
        string $nombre,
        string $correo,
        string $passwordHash,
        string $telefono,
        int $rol
    ): void {
        $conexion = Database::conectar();

        $stmt = $conexion->prepare(
            "INSERT INTO usuario
            (nombre, correo, contraseña, telefono, rol)
            VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssi", $nombre, $correo, $passwordHash, $telefono, $rol);
        $stmt->execute();
        $stmt->close();
    }
}

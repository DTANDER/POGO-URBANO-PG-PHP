<?php
// Clase base: todos los controladores heredan de aquí
class Controller
{
    /**
     * Carga una vista de app/views/ pasándole variables.
     * Si indicas un layout (ej: "main"), la vista se mete dentro de él.
     */
    protected function vista(string $nombre, array $datos = [], ?string $layout = null): void
    {
        extract($datos);

        if ($layout === null) {
            require __DIR__ . "/../views/$nombre.php";
            return;
        }

        ob_start();
        require __DIR__ . "/../views/$nombre.php";
        $contenido = ob_get_clean();

        require __DIR__ . "/../views/layout/$layout.php";
    }

    protected function redirigir(string $destino): void
    {
        header("Location: $destino");
        exit;
    }

    // Responde en JSON (lo usa el carrito con fetch)
    protected function json(array $datos): void
    {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($datos);
        exit;
    }

    protected function estaLogueado(): bool
    {
        return isset($_SESSION["id_usuario"]);
    }

    // Solo deja pasar a administradores (se comprueba en el servidor con la sesión)
    protected function exigirAdmin(): void
    {
        if (!$this->estaLogueado()) {
            $this->redirigir("index.php?page=login");
        }

        if ((int) ($_SESSION["rol"] ?? 0) !== Usuario::ROL_ADMIN) {
            $this->redirigir("index.php?page=inicio");
        }
    }
}

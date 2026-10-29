<?php
class CartaController extends Controller
{
    public function index(): void
    {
        $logueado        = $this->estaLogueado();
        $nombreUsuario   = $_SESSION["nombre"] ?? "";
        $telefonoUsuario = "";

        // Datos del usuario para precargar el formulario de entrega
        if ($logueado) {
            $usuario = Usuario::buscarPorId((int) $_SESSION["id_usuario"]);

            if ($usuario) {
                $nombreUsuario   = $usuario["nombre"];
                $telefonoUsuario = $usuario["telefono"];
            }
        }

        // Productos desde MySQL
        $categorias = [];
        $error      = "";

        try {
            $categorias = Producto::disponiblesPorCategoria();
        } catch (Throwable $e) {
            $error = "Error al cargar la carta.";
        }

        $this->vista("carta/index", [
            "titulo"          => "Carta | PG",
            "css"             => ["CSS/style.css", "CSS/carta.css"],
            "scripts"         => ["script.js", "js/carta.js"],
            "logueado"        => $logueado,
            "nombreUsuario"   => $nombreUsuario,
            "telefonoUsuario" => $telefonoUsuario,
            "categorias"      => $categorias,
            "error"           => $error,
            "imagenes"        => require __DIR__ . "/../config/imagenes.php",
            "imagenDefecto"   => "media/img/carta/sin-imagen.png",
        ], "main");
    }
}

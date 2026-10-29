<?php
class ReservaController extends Controller
{
    public function index(): void
    {
        // Para reservar hay que haber iniciado sesión
        if (!$this->estaLogueado()) {
            $this->redirigir("index.php?page=login");
        }

        $idUsuario = (int) $_SESSION["id_usuario"];

        // Datos del usuario (se muestran en el formulario, solo lectura)
        $nombreUsuario   = $_SESSION["nombre"] ?? "";
        $telefonoUsuario = "";

        $usuario = Usuario::buscarPorId($idUsuario);

        if ($usuario) {
            $nombreUsuario   = $usuario["nombre"];
            $telefonoUsuario = $usuario["telefono"];
        }

        $errores         = [];
        $reservaExitosa  = false;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $fecha    = trim($_POST["fecha"] ?? "");
            $hora     = trim($_POST["hora"] ?? "");
            $personas = intval($_POST["personas"] ?? 0);
            $mesa     = intval($_POST["mesa"] ?? 0);

            /* VALIDACIONES */

            if ($fecha === "") {
                $errores[] = "Debes seleccionar una fecha.";
            }

            if ($hora === "") {
                $errores[] = "Debes seleccionar una hora.";
            }

            if ($personas <= 0) {
                $errores[] = "La cantidad de personas debe ser mayor a 0.";
            }

            if ($mesa <= 0) {
                $errores[] = "Debes seleccionar una mesa.";
            }

            // La fecha no puede ser anterior a hoy
            if ($fecha !== "" && $fecha < date("Y-m-d")) {
                $errores[] = "No puedes reservar una fecha anterior a hoy.";
            }

            /* DISPONIBILIDAD DE LA MESA */

            if (empty($errores) && Reserva::mesaOcupada($fecha, $hora, $mesa)) {
                $errores[] = "La mesa $mesa no está disponible para esa fecha y hora.";
            }

            /* GUARDAR */

            if (empty($errores)) {

                try {

                    Reserva::crear($idUsuario, $fecha, $hora, $personas, $mesa, "Reservada");

                    $reservaExitosa = true;

                } catch (mysqli_sql_exception $e) {

                    $errores[] = "Ocurrió un error al guardar la reserva.";
                }
            }
        }

        $this->vista("reserva/index", [
            "titulo"          => "RESERVAS | PG",
            "css"             => ["CSS/style.css", "CSS/reserva.css"],
            "scripts"         => ["script.js", "js/reserva.js"],
            "nombreUsuario"   => $nombreUsuario,
            "telefonoUsuario" => $telefonoUsuario,
            "errores"         => $errores,
            "reservaExitosa"  => $reservaExitosa,
        ], "main");
    }
}

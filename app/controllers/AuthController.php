<?php
// CONTROLADOR: recibe lo que envía el formulario, usa el modelo y elige la vista
class AuthController extends Controller
{
    public function login(): void
    {
        // Si ya inició sesión, no tiene sentido mostrar el login
        if (isset($_SESSION["id_usuario"])) {
            $this->redirigir("index.php?page=inicio");
        }

        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $correo   = trim($_POST["correo"] ?? "");
            $password = $_POST["pass"] ?? "";

            if ($correo === "" || $password === "") {

                $mensaje = "Debes completar todos los campos.";

            } else {

                $usuario = Usuario::buscarPorCorreo($correo);

                if ($usuario && password_verify($password, $usuario["contraseña"])) {

                    session_regenerate_id(true);

                    $_SESSION["id_usuario"] = $usuario["id_usuario"];
                    $_SESSION["nombre"]     = $usuario["nombre"];
                    $_SESSION["correo"]     = $usuario["correo"];
                    $_SESSION["rol"]        = $usuario["rol"];

                    // El administrador va a su panel; los clientes al inicio
                    if ((int) $usuario["rol"] === Usuario::ROL_ADMIN) {
                        $this->redirigir("index.php?page=admin");
                    }

                    $this->redirigir("index.php?page=inicio");
                }

                $mensaje = "Correo o contraseña incorrectos.";
            }
        }

        $this->vista("auth/login", ["mensaje" => $mensaje]);
    }

    public function logout(): void
    {
        // 1) vaciar los datos de la sesión
        $_SESSION = [];

        // 2) borrar también la cookie de sesión del navegador
        if (ini_get("session.use_cookies")) {
            $p = session_get_cookie_params();
            setcookie(
                session_name(), "", time() - 42000,
                $p["path"], $p["domain"], $p["secure"], $p["httponly"]
            );
        }

        // 3) destruir la sesión en el servidor
        session_destroy();

        $this->redirigir("index.php?page=inicio");
    }

    public function registro(): void
    {
        // Si ya inició sesión, no tiene sentido registrarse
        if (isset($_SESSION["id_usuario"])) {
            $this->redirigir("index.php?page=inicio");
        }

        $errores         = [];
        $registroExitoso = false;
        $valores         = [];   // lo escrito, para no borrar el formulario si hay errores

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $valores   = $_POST;

            $nombre    = trim($_POST["nombre"] ?? "");
            $correo    = trim($_POST["correo"] ?? "");
            $telefono  = trim($_POST["telefono"] ?? "");
            $password  = $_POST["password"] ?? "";
            $confirmar = $_POST["confirmar"] ?? "";

            /* VALIDACIONES BÁSICAS */

            if ($nombre === "") {
                $errores[] = "Debes ingresar tu nombre completo.";
            }

            if ($correo === "") {
                $errores[] = "Debes ingresar tu correo electrónico.";
            }

            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El correo electrónico no es válido.";
            }

            if ($telefono === "") {
                $errores[] = "Debes ingresar tu número de teléfono.";
            }

            if (!preg_match('/^[0-9]{7,15}$/', $telefono)) {
                $errores[] = "El teléfono debe contener entre 7 y 15 números.";
            }

            if ($password === "") {
                $errores[] = "Debes ingresar una contraseña.";
            }

            if (strlen($password) < 4) {
                $errores[] = "La contraseña debe tener al menos 4 caracteres.";
            }

            if ($password !== $confirmar) {
                $errores[] = "Las contraseñas no coinciden.";
            }

            /* COMPROBAR CORREO Y TELÉFONO REPETIDOS */

            if (empty($errores)) {

                foreach (Usuario::buscarPorCorreoOTelefono($correo, $telefono) as $existente) {

                    if (strtolower($existente["correo"]) === strtolower($correo)) {
                        $errores[] = "Este correo ya está registrado. Usa otro correo.";
                    }

                    if ($existente["telefono"] === $telefono) {
                        $errores[] = "Este número de teléfono ya está registrado. Usa otro número.";
                    }
                }
            }

            /* GUARDAR USUARIO (rol 0 = cliente) */

            if (empty($errores)) {

                try {

                    Usuario::crear(
                        $nombre,
                        $correo,
                        password_hash($password, PASSWORD_DEFAULT),
                        $telefono,
                        0
                    );

                    $registroExitoso = true;
                    $valores         = [];

                } catch (mysqli_sql_exception $e) {

                    if ($e->getCode() == 1062) {
                        $errores[] = "El correo o el teléfono ya están registrados.";
                    } else {
                        $errores[] = "Ocurrió un error al registrar el usuario.";
                    }
                }
            }
        }

        $this->vista("auth/registro", [
            "errores"         => $errores,
            "registroExitoso" => $registroExitoso,
            "valores"         => $valores,
        ]);
    }
}

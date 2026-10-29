<?php
// CONTROLADOR FRONTAL: toda página migrada entra por aquí (index.php?page=...)
session_start();

// Que el navegador no guarde copias: así "atrás" nunca muestra una sesión vieja
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

require_once __DIR__ . "/app/core/Database.php";
require_once __DIR__ . "/app/core/Controller.php";
require_once __DIR__ . "/app/core/helpers.php";

require_once __DIR__ . "/app/models/Usuario.php";
require_once __DIR__ . "/app/models/Producto.php";
require_once __DIR__ . "/app/models/Pedido.php";
require_once __DIR__ . "/app/models/Reserva.php";
require_once __DIR__ . "/app/models/Equipo.php";

require_once __DIR__ . "/app/controllers/AuthController.php";
require_once __DIR__ . "/app/controllers/InicioController.php";
require_once __DIR__ . "/app/controllers/CartaController.php";
require_once __DIR__ . "/app/controllers/PedidoController.php";
require_once __DIR__ . "/app/controllers/ReservaController.php";
require_once __DIR__ . "/app/controllers/ContactoController.php";
require_once __DIR__ . "/app/controllers/SomosController.php";
require_once __DIR__ . "/app/controllers/AdminController.php";

// página => [Controlador, método]
$rutas = [
    "login"        => ["AuthController",   "login"],
    "logout"       => ["AuthController",   "logout"],
    "registrarse"  => ["AuthController",   "registro"],
    "inicio"       => ["InicioController", "index"],
    "carta"        => ["CartaController",  "index"],
    "pedido_crear" => ["PedidoController", "crear"],
    "reserva"      => ["ReservaController", "index"],
    "contacto"     => ["ContactoController", "index"],
    "somos"        => ["SomosController",    "index"],
    "admin"        => ["AdminController",    "index"],
];

$page = $_GET["page"] ?? "inicio";

if (!isset($rutas[$page])) {
    http_response_code(404);
    exit("Página no encontrada.");
}

[$clase, $metodo] = $rutas[$page];
(new $clase())->$metodo();

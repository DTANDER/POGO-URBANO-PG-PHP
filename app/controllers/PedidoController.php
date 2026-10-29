<?php
// Lo llama el carrito con fetch() y siempre responde en JSON
class PedidoController extends Controller
{
    public function crear(): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->json(["ok" => false, "mensaje" => "Método no permitido."]);
        }

        if (!$this->estaLogueado()) {
            $this->json(["ok" => false, "mensaje" => "Debes iniciar sesión para hacer un pedido."]);
        }

        $datos = json_decode(file_get_contents("php://input"), true);

        if (!is_array($datos)) {
            $this->json(["ok" => false, "mensaje" => "Datos inválidos."]);
        }

        $direccion = trim($datos["direccion"] ?? "");
        $pago      = trim($datos["pago"] ?? "");
        $items     = $datos["productos"] ?? [];

        $pagosValidos = ["Efectivo", "Tarjeta", "Nequi", "Daviplata", "Bancolombia"];

        if ($direccion === "") {
            $this->json(["ok" => false, "mensaje" => "Debes ingresar una dirección."]);
        }

        if (!in_array($pago, $pagosValidos, true)) {
            $this->json(["ok" => false, "mensaje" => "Debes seleccionar un medio de pago."]);
        }

        if (!is_array($items) || empty($items)) {
            $this->json(["ok" => false, "mensaje" => "Tu carrito está vacío."]);
        }

        try {

            $resultado = Pedido::crear(
                (int) $_SESSION["id_usuario"], $direccion, $pago, $items
            );

            $this->json([
                "ok"        => true,
                "mensaje"   => "¡Pedido realizado con éxito! Gracias por elegir Pogo Urbano.",
                "id_pedido" => $resultado["id_pedido"],
                "total"     => $resultado["total"],
            ]);

        } catch (Exception $e) {

            $this->json(["ok" => false, "mensaje" => $e->getMessage()]);
        }
    }
}

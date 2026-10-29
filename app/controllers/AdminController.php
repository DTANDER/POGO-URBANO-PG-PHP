<?php
class AdminController extends Controller
{
    public function index(): void
    {
        // Solo administradores (rol comprobado en el servidor)
        $this->exigirAdmin();

        $this->vista("admin/index", [
            "nombreAdmin" => $_SESSION["nombre"] ?? "Administrador",
        ]);
    }
}

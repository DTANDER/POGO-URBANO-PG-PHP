<?php
class InicioController extends Controller
{
    public function index(): void
    {
        $this->vista("inicio/index", [
            "titulo"  => "POGO URBANO | SAZÓN Y SABOR",
            "css"     => ["CSS/style.css"],
            "scripts" => ["script.js"],
        ], "main");
    }
}

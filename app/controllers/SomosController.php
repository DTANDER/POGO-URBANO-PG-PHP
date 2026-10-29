<?php
class SomosController extends Controller
{
    public function index(): void
    {
        $this->vista("somos/index", [
            "titulo"  => "POGO HISTORY | PG",
            "css"     => ["CSS/style.css", "CSS/quienes.css"],
            "scripts" => ["script.js"],
            "equipo"  => Equipo::todos(),
        ], "main");
    }
}

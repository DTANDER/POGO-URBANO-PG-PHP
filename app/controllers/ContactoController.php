<?php
class ContactoController extends Controller
{
    public function index(): void
    {
        $this->vista("contacto/index", [
            "titulo"  => "Contactos | PG",
            "css"     => ["CSS/style.css", "CSS/contactos.css"],
            "scripts" => ["script.js"],
        ], "main");
    }
}

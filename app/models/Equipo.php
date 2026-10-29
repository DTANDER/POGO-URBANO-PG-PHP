<?php
// MODELO: integrantes del equipo.
// Por ahora los datos están aquí; más adelante pueden venir de una tabla "equipo".
class Equipo
{
    public static function todos(): array
    {
        return [
        [
            "apodo" => "Charawi",
            "nombre" => "ANDERSON VELÁSQUEZ",
            "descripcion" => "Charawi es un joven de 15 años de la ciudad de Medellín, una de las mentes más brillantes de El Pogo y dueño del 20% de las acciones del Pogo, fue estudiante de la Jose Roberto Vasquez con una maestría en la Universidad Pascual Bravo",
        ],
        [
            "apodo" => "Yexiz",
            "nombre" => "YESSI SARMIENTO",
            "descripcion" => "Yexiz es un joven de 17 años de la ciudad de Medellín, el inventor más creativo de El Pogo y dueño del 20% de las acciones del Pogo, fue estudiante de la Jose Roberto Vasquez con una maestría en la Universidad Pascual Bravo",
        ],
        [
            "apodo" => "Chomby",
            "nombre" => "DIOMEDEZ LOTERO",
            "descripcion" => "Chomby es un joven de 17 años de la ciudad de Medellín, una de las mentes más brillantes y responsable de la comida del Pogo y dueño del 20% de las acciones del Pogo, fue estudiante de la Jose Roberto Vasquez con una maestría en la Universidad Pascual Bravo",
        ],
        [
            "apodo" => "Diezki",
            "nombre" => "SAMUEL DIEZ",
            "descripcion" => "Diezki es un joven de 15 años de la ciudad de Medellín, uno de los mayores inversionistas de El Pogo y dueño del 20% de las acciones del Pogo, fue estudiante de la Jose Roberto Vasquez con una maestría en la Universidad Pascual Bravo",
        ],
    ];
    }
}

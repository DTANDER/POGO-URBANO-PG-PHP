<?php
// Funciones sueltas que se pueden usar en cualquier vista

function formatearPrecio($precio): string
{
    return '$' . number_format((float) $precio, 0, ',', '.');
}

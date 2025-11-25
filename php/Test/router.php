<?php

// Si no viene ningún parámetro, mostrar error
if (!isset($_GET['test'])) {
    echo "<h2>Error: No se especificó ningún test.</h2>";
    exit;
}

$test = $_GET['test'];

// Todos los tests registrados
$tests = [
    "ansiedad" => "tests/test_ansiedad.php",
    "adiccion" => "tests/test_adiccion.php",
    "depresion" => "tests/test_depresion.php",
    "burnout" => "tests/test_burnout.php",
];

// Validar si el test existe
if (!array_key_exists($test, $tests)) {
    echo "<h2>Error: El test solicitado no existe.</h2>";
    exit;
}

// Cargar el archivo correspondiente
include $tests[$test];

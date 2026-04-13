<?php
require_once("config/conexion.php");

$rutaConfigurada = Conectar::ruta_libros();
$rutaReal = @realpath($rutaConfigurada);
$esDirectorio = @is_dir($rutaConfigurada);
$esLegible = @is_readable($rutaConfigurada);
$listado = [];
$error = null;

try {
    if($esDirectorio){
        $items = @scandir($rutaConfigurada);
        if($items !== false){
            $listado = array_slice(array_values(array_diff($items, [".", ".."])), 0, 10);
        } else {
            $error = error_get_last();
        }
    } else {
        $error = error_get_last();
    }
} catch (Throwable $e) {
    $error = $e->getMessage();
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode([
    "ruta_configurada" => $rutaConfigurada,
    "ruta_real" => $rutaReal,
    "is_dir" => $esDirectorio,
    "is_readable" => $esLegible,
    "listado_muestra" => $listado,
    "error" => $error
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

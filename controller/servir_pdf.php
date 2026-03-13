<?php
    require_once("../config/conexion.php");

    if(!isset($_GET["f"]) || empty($_GET["f"])){
        http_response_code(400);
        exit("Parametro requerido.");
    }

    $ruta = base64_decode($_GET["f"]);
    $ruta = realpath($ruta);

    $ruta_base = realpath("C:RutasPDF/");

    if($ruta === false || $ruta_base === false){
        http_response_code(404);
        exit("Archivo no encontrado.");
    }

    if(strpos($ruta, $ruta_base) !== 0){
        http_response_code(403);
        exit("Acceso denegado.");
    }

    if(!file_exists($ruta) || !is_file($ruta)){
        http_response_code(404);
        exit("Archivo no encontrado.");
    }

    if(strtolower(pathinfo($ruta, PATHINFO_EXTENSION)) !== 'pdf'){
        http_response_code(403);
        exit("Tipo de archivo no permitido.");
    }

    $nombre = basename($ruta);
    $tamano = filesize($ruta);

    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=\"" . $nombre . "\"");
    header("Content-Length: " . $tamano);
    header("Cache-Control: private, max-age=3600");
    header("Accept-Ranges: bytes");

    readfile($ruta);
    exit();
?>

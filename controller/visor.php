<?php
    require_once("../config/conexion.php");
    require_once("../models/Visor.php");
    $visor = new Visor();

    switch($_GET["op"]){

        case "combo_categorias":
            $datos = $visor->combo_categorias();
            $html = "";
            foreach($datos as $row){
                $html .= "<option value='".$row["cat_id"]."'>".$row["cat_nom"]."</option>";
            }
            echo $html;
        break;

        case "combo_prioridades":
            $datos = $visor->combo_prioridades();
            $html = "";
            foreach($datos as $row){
                $html .= "<option value='".$row["prio_id"]."'>".$row["prio_nom"]."</option>";
            }
            echo $html;
        break;

        case "buscar_pdfs":
            $municipio = isset($_POST["municipio"]) ? trim($_POST["municipio"]) : "";
            $seccion   = isset($_POST["seccion"])   ? trim($_POST["seccion"])   : "";
            $volumen   = isset($_POST["volumen"])   ? trim($_POST["volumen"])   : "";
            $libro     = isset($_POST["libro"])     ? trim($_POST["libro"])     : "";
            $anio      = isset($_POST["anio"])      ? trim($_POST["anio"])      : "";

            $datos = $visor->buscar_pdfs($municipio, $seccion, $volumen, $libro, $anio);

            $resultado = [];
            foreach($datos as $row){
                $ruta_encoded = base64_encode($row["ruta"]);
                $resultado[] = [
                    "nombre"  => $row["nombre"],
                    "ruta"    => $ruta_encoded,
                    "url"     => "../../controller/servir_pdf.php?f=" . urlencode($ruta_encoded),
                    "carpeta" => $row["carpeta"]
                ];
            }
            echo json_encode($resultado);
        break;

        case "registrar_log":
            $usu_id      = isset($_POST["usu_id"])      ? intval($_POST["usu_id"])          : 0;
            $pdf_nombre  = isset($_POST["pdf_nombre"])  ? trim($_POST["pdf_nombre"])         : "";
            $pdf_ruta    = isset($_POST["pdf_ruta"])    ? base64_decode($_POST["pdf_ruta"])  : "";
            if($usu_id > 0 && !empty($pdf_nombre)){
                $visor->registrar_log($usu_id, $pdf_nombre, $pdf_ruta);
            }
            echo json_encode(["status" => "ok"]);
        break;

    case "debug_scan":
            $ruta_base = "C:\\Users\\sergio.asencio\\Desktop\\Sergio\\bk-visor\\LIBROS\\07";
            $info = [
                "ruta_base"      => $ruta_base,
                "is_dir"         => is_dir($ruta_base),
                "is_readable"    => is_readable($ruta_base),
                "contenido"      => [],
            ];
            if(is_dir($ruta_base)){
                $items = scandir($ruta_base);
                foreach($items as $item){
                    if($item === '.' || $item === '..') continue;
                    $ruta = $ruta_base . DIRECTORY_SEPARATOR . $item;
                    $partes = explode('_', $item);
                    $info["contenido"][] = [
                        "nombre"        => $item,
                        "es_dir"        => is_dir($ruta),
                        "num_partes"    => count($partes),
                        "partes"        => $partes,
                        "municipio_pos1"=> isset($partes[1]) ? $partes[1] : null,
                        "seccion_pos2"  => isset($partes[2]) ? $partes[2] : null,
                        "libro_pos3"    => isset($partes[3]) ? $partes[3] : null,
                        "volumen_pos5"  => isset($partes[5]) ? $partes[5] : null,
                    ];
                }
            }
            header('Content-Type: application/json');
            echo json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        break;

    }
?>

<?php
    require_once("../config/conexion.php");
    require_once("../models/Visor.php");
    $visor = new Visor();

    switch($_GET["op"]){

        case "combo_municipios":
            $datos = $visor->combo_municipios();
            $html = "<option value=''>-- Seleccione --</option>";
            foreach($datos as $row){
                $html .= "<option value='".$row["mun_codigo"]."'>".$row["mun_nombre"]."</option>";
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

        default:
            http_response_code(400);
            echo json_encode(["error" => "Operacion no valida"]);
        break;
    }
?>

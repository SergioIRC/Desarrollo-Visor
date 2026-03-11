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
            $titulo  = isset($_POST["titulo"])  ? trim($_POST["titulo"])  : "";
            $cat_id  = isset($_POST["cat_id"])  ? trim($_POST["cat_id"])  : "";
            $prio_id = isset($_POST["prio_id"]) ? trim($_POST["prio_id"]) : "";

            $datos = $visor->buscar_pdfs($titulo, $cat_id, $prio_id);

            $resultado = [];
            foreach($datos as $row){
                $ruta_encoded = base64_encode($row["ruta"]);
                $resultado[] = [
                    "nombre"    => $row["nombre"],
                    "ruta"      => $ruta_encoded,
                    "url"       => "../../controller/servir_pdf.php?f=" . urlencode($ruta_encoded),
                    "categoria" => $row["categoria"],
                    "prioridad" => $row["prioridad"]
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

    }
?>

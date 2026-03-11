<?php
    require_once("../../config/conexion.php");
    /* TODO: Destruir Session */
    session_destroy();
    if($_SESSION["rol_id"] == 1){
        /* TODO: Luego de cerrar session enviar a la pantalla de login */
        header("Location:".Conectar::ruta()."index.php");
    }elseif($_SESSION["rol_id"] == 2){
        header("Location:".Conectar::ruta()."view/accesosoporte/index.php");
    }

    exit();
?>
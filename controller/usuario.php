<?php
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");

    $usuario = new Usuario();
    $key = "mi_key_secret";
    $cipher = "aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    switch($_GET["op"]){
        case "password":
            $cifrado = openssl_encrypt($_POST["usu_pass"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $usuario->update_usuario_pass($_POST["usu_id"], $textoCifrado);
            break;

        default:
            http_response_code(400);
            echo json_encode(["error" => "Operacion no valida"]);
            break;
    }
?>

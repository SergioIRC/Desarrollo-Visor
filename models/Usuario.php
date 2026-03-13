<?php
    class Usuario extends Conectar{

        public function login(){
            $conectar = parent::conexion();
            parent::set_names();

            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"];

                if(empty($correo) || empty($pass)){
                    header("Location:".Conectar::ruta()."index.php?m=2");
                    exit();
                }

                $sql = "SELECT * FROM tm_usuario WHERE usu_correo=? and est=1 LIMIT 1";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $correo);
                $stmt->execute();
                $resultado = $stmt->fetch();

                if($resultado){
                    $textocifrado = $resultado["usu_pass"];
                    $key = "mi_key_secret";
                    $cipher = "aes-256-cbc";
                    $iv_dec = substr(base64_decode($textocifrado), 0, openssl_cipher_iv_length($cipher));
                    $cifradoSinIV = substr(base64_decode($textocifrado), openssl_cipher_iv_length($cipher));
                    $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

                    if($decifrado == $pass){
                        $_SESSION["usu_id"] = $resultado["usu_id"];
                        $_SESSION["usu_nom"] = $resultado["usu_nom"];
                        $_SESSION["usu_ape"] = $resultado["usu_ape"];
                        $_SESSION["rol_id"] = $resultado["rol_id"];
                        header("Location:".Conectar::ruta()."view/ConsultarPDF/");
                        exit();
                    }
                }

                header("Location:".Conectar::ruta()."index.php?m=1");
                exit();
            }
        }

        public function update_usuario_pass($usu_id, $usu_pass){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_usuario
                SET
                    usu_pass = ?
                WHERE
                    usu_id = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_pass);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $sql->fetchAll();
        }
    }
?>

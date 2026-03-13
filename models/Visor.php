<?php
    class Visor extends Conectar{

        private $ruta_base = "C:RutasPDF/";

        public function combo_municipios(){
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "SELECT mun_nombre, mun_codigo FROM tm_municipios_visor WHERE activo = 1 ORDER BY mun_nombre ASC";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscar_pdfs($municipio, $seccion, $volumen, $libro, $anio){
            $archivos = [];
            $this->escanear_carpeta($this->ruta_base, $municipio, $seccion, $volumen, $libro, $anio, $archivos);
            return $archivos;
        }

        private function escanear_carpeta($carpeta, $municipio, $seccion, $volumen, $libro, $anio, &$archivos){
            if(!is_dir($carpeta)) return;

            $items = scandir($carpeta);
            foreach($items as $item){
                if($item === '.' || $item === '..') continue;

                $ruta = $carpeta . DIRECTORY_SEPARATOR . $item;

                if(is_dir($ruta)){
                    $partes = explode('_', $item);
                    if(count($partes) >= 7){
                        $dir_municipio = intval($partes[1]);
                        $dir_seccion   = intval($partes[2]);
                        $dir_libro     = intval($partes[3]);
                        $dir_volumen   = intval($partes[5]);
                        $dir_anio      = intval($partes[6]);

                        $coincide = true;
                        if($municipio !== '' && $dir_municipio !== intval($municipio)) $coincide = false;
                        if($seccion   !== '' && $dir_seccion   !== intval($seccion))   $coincide = false;
                        if($volumen   !== '' && $dir_volumen   !== intval($volumen))   $coincide = false;
                        if($libro     !== '' && $dir_libro     !== intval($libro))     $coincide = false;
                        if($anio      !== '' && $dir_anio      !== intval($anio))      $coincide = false;

                        if($coincide){
                            $this->recopilar_pdfs($ruta, $item, $archivos);
                        }
                    } else {
                        $this->escanear_carpeta($ruta, $municipio, $seccion, $volumen, $libro, $anio, $archivos);
                    }
                }
            }
        }

        private function recopilar_pdfs($carpeta, $nombre_carpeta, &$archivos){
            if(!is_dir($carpeta)) return;

            $items = scandir($carpeta);
            foreach($items as $item){
                if($item === '.' || $item === '..') continue;

                $ruta = $carpeta . DIRECTORY_SEPARATOR . $item;

                if(is_dir($ruta)){
                    $this->recopilar_pdfs($ruta, $nombre_carpeta, $archivos);
                } elseif(strtolower(pathinfo($item, PATHINFO_EXTENSION)) === 'pdf'){
                    $archivos[] = [
                        "nombre"  => $item,
                        "ruta"    => $ruta,
                        "carpeta" => $nombre_carpeta
                    ];
                }
            }
        }

        public function registrar_log($usu_id, $pdf_nombre, $pdf_ruta){
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "INSERT INTO tm_log_visor (log_id, usu_id, pdf_nombre, pdf_ruta, fech_consulta) VALUES (NULL, ?, ?, ?, NOW())";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->bindValue(2, $pdf_nombre);
            $stmt->bindValue(3, $pdf_ruta);
            $stmt->execute();
        }
    }
?>

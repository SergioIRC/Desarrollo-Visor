<?php
    class Visor extends Conectar{

        private $ruta_base = "C:\\Users\\sergio.asencio\\Desktop\\Sergio\\bk-visor\\LIBROS\\07";

        public function combo_categorias(){
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "SELECT cat_id, cat_nom FROM tm_categoria WHERE est = 1 ORDER BY cat_nom";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function combo_prioridades(){
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "SELECT prio_id, prio_nom FROM tm_prioridad WHERE est = 1 ORDER BY prio_id";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscar_pdfs($titulo, $cat_id, $prio_id){
            $conectar = parent::Conexion();
            parent::set_names();

            $cat_nom  = "";
            $prio_nom = "";

            if(!empty($cat_id)){
                $sql = "SELECT cat_nom FROM tm_categoria WHERE cat_id = ? AND est = 1";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $cat_id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row) $cat_nom = $row["cat_nom"];
            }

            if(!empty($prio_id)){
                $sql = "SELECT prio_nom FROM tm_prioridad WHERE prio_id = ? AND est = 1";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $prio_id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row) $prio_nom = $row["prio_nom"];
            }

            $archivos = [];
            $this->escanear_carpeta($this->ruta_base, $titulo, $archivos);

            $resultado = [];
            foreach($archivos as $ruta_completa){
                $nombre = basename($ruta_completa);
                $resultado[] = [
                    "nombre"    => $nombre,
                    "ruta"      => $ruta_completa,
                    "categoria" => !empty($cat_nom)  ? $cat_nom  : "General",
                    "prioridad" => !empty($prio_nom) ? $prio_nom : "Normal"
                ];
            }

            return $resultado;
        }

        private function escanear_carpeta($carpeta, $titulo, &$archivos){
            if(!is_dir($carpeta)) return;

            $items = scandir($carpeta);
            foreach($items as $item){
                if($item === '.' || $item === '..') continue;

                $ruta = $carpeta . DIRECTORY_SEPARATOR . $item;

                if(is_dir($ruta)){
                    $this->escanear_carpeta($ruta, $titulo, $archivos);
                } elseif(strtolower(pathinfo($item, PATHINFO_EXTENSION)) === 'pdf'){
                    if(empty($titulo) || stripos($item, $titulo) !== false){
                        $archivos[] = $ruta;
                    }
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

<?php
    /* TODO: Inicio de Sesion en la WebApp */
    session_start();

    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {
                //TODO: Cadena de Conexion Local
				$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=DemoVisor","root","");
                //TODO: Cadena de Conexion Produccion
                //$conectar = $this->dbh = new PDO("mysql:host=localhost;dbname=Nombre_DB","Usuario","contraseña");
				return $conectar;
			} catch (Exception $e) {
				print "¡Error BD!: " . $e->getMessage() . "<br/>";
				die();
			}
        }

        /* TODO: Set Name para utf 8 español - evitar tener problemas con las tildes */
        public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
        }

        /* TODO: Ruta o Link del proyecto */
        public static function ruta(){
            //TODO: Ruta Proyecto Local
			return "http://localhost:9090/Desarrollo-Visor/";
            //TODO: Ruta Proyecto Produccion
            //return "http://URL_PRODUCCION/";
		}

        public static function ruta_libros(){
            //TODO: Ruta local de libros
            return "C:\\Users\\sergio.asencio\\Desktop\\Sergio\\bk-visor\\LIBROS\\07";
            //TODO: Ruta compartida para produccion
            //return "\\\\GEMINIS00\\libros cade\\LIBROS\\07";
        }

    }
?>

<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo') : "";

class Load {

    public function __construct() {
        
    }

    /*
     * ---------------------------------------------------------------
     * CARGADOR DE MODELOS
     * ---------------------------------------------------------------
     * 
     */

    static function Model($modulo, $modelo, $carpeta = '', $instanciar = true) {


        $nombre_modelo = $modelo . _MODEL_SUFIX_;
        $ruta_modulo = __MODULEFOLDER__ . strtolower($modulo);

        if (empty($carpeta)) {
            $ruta_completa = $ruta_modulo . "/m/" . $nombre_modelo . '.php';
        } else {
            $ruta_completa = $ruta_modulo . "/m/" . $carpeta . "/" . $nombre_modelo . '.php';
        }
        $nombre_clase = ucwords($nombre_modelo);
        if (is_file($ruta_completa) == false) {

            $descripcion = "La ruta del modelo no existe, verifiquelo <br><b>$ruta_completa</b>";
            Exceptions::MostrarError("ERROR DEL CARGADOR DE MODELO", $descripcion);
        }
        require_once $ruta_completa;

        if ($instanciar) {
            return new $nombre_clase;
        }
    }

    /*
     * ---------------------------------------------------------------
     * CARGADOR DE HELPERS
     * ---------------------------------------------------------------
     * 
     */

    static function Helper($helper) {
        $path_to_system_helper = __COREFOLDER__ . 'helpers/' . strtolower($helper) . 'Helper.php';
        if (!file_exists($path_to_system_helper)) {
            $path_to_helper = __APPFOLDER__ . 'helpers/' . strtolower($helper) . 'Helper.php';
        } else {
            $path_to_helper = $path_to_system_helper;
        }

        if (!file_exists($path_to_helper)) {
            exit("No existe el helper '$helper' o la clase esta mal llamada");
        }
        require_once $path_to_helper;
        $clase = ucwords($helper);
        return new $clase;
    }

    static function Controlador($modulo, $controller) {

        $nombre_controlador = $controller . "Controlador";
        $ruta_modulo = $_SERVER['DOCUMENT_ROOT'] . '/application/modulos/' . strtolower($modulo);
        $ruta_completa = $ruta_modulo . "/controladores/" . $nombre_controlador . '.php';
        require_once $ruta_completa;
    }

}

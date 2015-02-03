<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
/**
 * ------------------CONTROLADOR FRONTAL------------------
 * Recibe mediante GET, el moódulo,el controlador y la accion, los demas parametros
 * tambien se envian via GET.
 */
class FrontControlador {

    public function __construct() {

        //$config = Configuracion::singleton();
    }

    static function main() {

        require_once(__COREFOLDER__ . "Configuracion.php");
        require_once(__APPFOLDER__ . "/../config/conf.php");
        require_once(__COREFOLDER__ . "Epdo.php");
        require_once(__COREFOLDER__ . "ControladorBase.php");
        require_once(__COREFOLDER__ . "ModeloBase.php");
        require_once(__COREFOLDER__ . "libs/mobile_detect/Mobile_Detect.php");
        require_once(__COREFOLDER__ . "Vista.php");
        require_once(__COREFOLDER__ . "Load.php");
        require_once(__COREFOLDER__ . "/exceptions/exceptions.php");

        // parametros de entrada
        $_module = filter_input(INPUT_POST, 'mod', FILTER_SANITIZE_SPECIAL_CHARS);
        $_controller = filter_input(INPUT_POST, 'c', FILTER_SANITIZE_SPECIAL_CHARS);
        $_action = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_SPECIAL_CHARS);

        $config = Configuracion::singleton();

        if (!empty($_module)) {
            $nombreModulo = "modulos/" . $_module;
        } else {
            $nombreModulo = $config->get('default_module');
        }

        // Recibimos como parametros el controlador

        if (!empty($_controller)) {
            $nombreControlador = $_controller . _CONTROLLER_SUFIX_;
        } else {
            $nombreControlador = $config->get('default_controller')._CONTROLLER_SUFIX_;
        }

        // Parametros de accion

        if (!empty($_action)) {
            $nombreAccion = $_action;
        } else {
            $nombreAccion = $config->get('default_action');
        }

        // Ruta completa del controlador, se concatena con 
        // nombreModulo.nombreControlador.nombreAccion

        $rutaControlador = $nombreModulo . "/c/" . $nombreControlador . '.php';

        // incluimos el archivo que contiene la clase del controlador solicitado

        if (is_file($rutaControlador)) {
            require_once $rutaControlador;
        } else {
            $descripcion = "'El modulo ' . $rutaControlador .' no existe'";
            Exceptions::MostrarError("Error al encontrar ruta del controlador", $descripcion);
            return false;
        }

        // Si no existe la clase y la accion
        if (is_callable(array($nombreControlador, $nombreAccion)) == false) {

            $descripcion = "'El metodo no existen o no puede ser llamado :<br> "
                    . " controlador=' . $nombreControlador .' <br> "
                    . "metodo =<b> $nombreAccion'</b>";
            Exceptions::MostrarError("Error de Metodo", $descripcion);
            return false;
        }

        // Si todo esta bien creamos la instancia del controlador 
        // y llamamos a la accion

        $controlador = new $nombreControlador();
        $controlador->$nombreAccion();
    }

}

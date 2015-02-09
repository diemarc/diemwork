<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
/**
 * Clase abstracta controlador base, 
 * en el constructor pasa el modelo a la vista
 * todos los demas controladores seran extendidas de este
 */
abstract class ControladorBase {

    protected $profiler,$auth,$vista,$utils,$conf,$redirect;

    public function __construct() {
        $this->conf = Configuracion::singleton();
        $this->vista = new Vista();
        $this->redirect = load::Helper("redirect");
        $this->auth = load::Helper("auth");
    }

    
    
}

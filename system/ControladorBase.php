<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
/**
 * Clase abstracta controlador base, 
 * en el constructor pasa el modelo a la vista
 * todos los demas controladores seran extendidas de este
 */
abstract class ControladorBase {

    protected $profiler;
    protected $auth;
    protected $vista;

    public function __construct() {
        $this->vista = new Vista();
        $this->redirect = load::Helper("profiler");
        $this->auth = load::Helper("login");
    }

    protected function checkIsLogged(){
        if(!$this->auth->checkLogin()){
            $this->vista->cargarVista('sistema','login/login',true);
            exit();
        }
    }
    
}

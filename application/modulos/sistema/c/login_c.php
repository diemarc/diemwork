<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";

class login_c extends ControladorBase {

    public function __construct() {
        parent::__construct();
        
    }


    public function index() {
        
        $this->auth->checkLogin();
        $this->vista->cargarVista("sistema", "welcome", "", true, true);
    }
   
}
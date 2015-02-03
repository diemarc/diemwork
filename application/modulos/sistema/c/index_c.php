<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";

class Index_c extends ControladorBase {

    public function __construct() {
        parent::__construct();
       
        
    }


    public function index() {
        $this->checkIsLogged();
        $this->vista->cargarVista("sistema", "welcome", "", true);
    }

    
    
    
}

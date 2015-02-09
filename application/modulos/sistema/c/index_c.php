<?php

(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo') : "";

class Index_c extends ControladorBase {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->vista->cargarVista("sistema", "index", "", true);
    }

    public function showPanel() {

        $this->auth->checkLogin();
        $this->vista->cargarVista("sistema", "panel", "", true);
    }
    
    

}

<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo') : "";

class login_c extends ControladorBase {


    public function __construct() {
        parent::__construct();
        
       
    }

    public function logIn(){
        if($this->auth->doLogin()){
            $this->redirect->cargarControlador("sistema","index","showPanel");
        }
        
    }
    
    public function logOut(){
       
        if($this->auth->closeSession()){
            exit("adios");
        }
        
    }

}

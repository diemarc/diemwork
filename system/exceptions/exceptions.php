<?php

class Exceptions {

    public function __construct() {
        
    }

    static function MostrarError($titulo , $descripcion) {

        include __APPFOLDER__ . '/pages/error/error_page.php';
    }

}

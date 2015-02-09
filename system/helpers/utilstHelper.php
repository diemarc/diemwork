<?php

class Utils {

    public function __construct() {
       
    }

    // control de parametros

    public function checkRequired($param) {

        if (empty($param)) {
            Exceptions::MostrarError("Parametro obligatorio vacio", "Algun parametro obligatorio es nulo");
        }
    }
    
    
    /*metodo generico para parametros de tipo id*/
    public function getIdRequired($id){
        
        $this->checkParamType($id, "num");
        return $id;
        
    }
    public function getFieldRequired($field){
        
        $this->checkRequired($field);
        return $field;
        
    }
    public function getArrayRequired($array){
        
        $this->checkParamType($array,"array");
        return $array;
        
    }

}
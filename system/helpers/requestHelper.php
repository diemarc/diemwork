<?php

class Request {

    public function __construct() {
        foreach ($_REQUEST as $k => $p) {
            if (!is_array($_REQUEST[$k])) {
                $_REQUEST[$k] = addslashes($p);
            }
        }
    }

    /**
     * Arma la consulta para insertar registros mediante los request
     * @return string
     */
    public function getFieldsInsertArray($array) {

        $values = "";
        $fields = "";
        foreach ($array as $f => $v) {
            if ($fields != "") {
                $fields .= ", ";
                $values .= ", ";
            }
            $fields .= $f;
            $values .= "'" . $v . "'";
        }
        $fields = "(" . $fields . ") VALUES (" . $values . ")";

        return $fields;
    }

    public function getFieldsInsertRequest() {

        $fields = "";
        foreach ($_REQUEST as $f => $v) {
            if ((substr($f, 0, 2) == "f_")) {
                if ($fields != "") {
                    $fields .= ", ";
                    $values .= ", ";
                }
                $fields .= substr($f, 2);
                $values .= "'" . $v . "'";
            }
        }
        $fields = "(" . $fields . ") VALUES (" . $values . ")";

        return $fields;
    }

    public function getParamRequest($modo) {

        $fields = "";
        $values = "";
        foreach ($_REQUEST as $f => $v) {
            if ((substr($f, 0, 2) == "p_")) {
                   $indice = substr($f, 2);
            }
            $valor = $v;
        }
       
        if($modo == "indice"){
            return $indice;
        }
        else {
            return $valor;
        }
        
    }

    public function getFieldsUpdateRequest() {

        // Campos a grabar
        $fields = "";
        foreach ($_REQUEST as $f => $v) {
            if ((substr($f, 0, 2) == "f_")) {
                if ($fields != "")
                    $fields .= ", ";
                $fields .= substr($f, 2) . " = '${v}'";
            }
        }

        return $fields;
    }

    /**
     * Arma la cadena para actualizar registros, mediante un array enviado desde la instancia desde un objeto
     * @return string,fields
     */
    public function getFieldsUpdateArray($array) {

        // Campos a grabar
        $fields = "";
        foreach ($array as $f => $v) {
            if ($fields != "") {
                $fields .= ", ";
            }
            $fields .= $f . " = '${v}'";
        }

        return $fields;
    }

    // control de parametros

    public function checkRequired($param) {

        if (empty($param)) {
            Exceptions::MostrarError("Parametro obligatorio vacio", "Algun parametro obligatorio es nulo");
        }
    }
    
    

    public function checkParamType($param, $type) {

        $this->checkRequired($param);
        $this->checkRequired($type);

        switch ($type) {
            case "num";

                if (!is_numeric($param)) {
                    Exceptions::MostrarError("Parametro no es numerico", "Solo se aceptan parametros numericos en $param");
                    die();
                }
                break;

            case "array";
                if (!is_array($param)) {
                    Exceptions::MostrarError("Parametro no es un array", "Se necesita que sea un array para poder procesar la solicitud");
                    die();
                }
                break;
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
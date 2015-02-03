<?php

class Paginacion {

    public $_ofset;
    public $_reg_per_page;
    public $_total_reg;
    public $_template_pager;
    public $_module;
    public $_controller;
    public $_action;

    public function __construct() {
      
    }

    /*Setters*/
    public function setTemplatePager($template) {
        $this->_template_pager = $template;
    }

    public function setOfset($ofset) {
        $this->_ofset = $ofset;
    }

    public function setRegPerPage($reg_per_page) {
        $this->_reg_per_page = $reg_per_page;
    }

    public function setTotalReg($total_reg) {
        $this->_total_reg = $total_reg;
    }
    
    public function setModule($module){
        $this->_module = $module;
    }
    public function setController($controller){
        $this->_controller = $controller;
    }
    public function setAction($action){
        $this->_action = $action;
    }

    
    public function getOfset(){
        $this->_ofset = (empty($_REQUEST["param_ofset"])) ? 0 : $_REQUEST["param_ofset"];
        $this->_ofset = ($this->_ofset < 0) ? 0 : $this->_ofset;
        return $this->_ofset;
    }
    
    public function paginar() {
        $registro_per_page = $this->_reg_per_page;
        $param_ofset = $this->getOfset();
        $siguiente = $param_ofset + $this->_reg_per_page;
        $anterior = $param_ofset - $this->_reg_per_page;
        $total = $this->_total_reg;
        
        // botones anterior,siguiente
        $btn_anterior = "?mod=".$this->_module."&c=".$this->_controller."&a=".$this->_action."&param_ofset=$anterior";
        $btn_siguiente = "?mod=".$this->_module."&c=".$this->_controller."&a=".$this->_action."&param_ofset=$siguiente";
        
        include($_SERVER['DOCUMENT_ROOT'] . "/template/paginacion/paginacion.php");
    }

}
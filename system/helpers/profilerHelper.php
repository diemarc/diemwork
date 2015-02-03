<?php

class Profiler {

    public $config;
    
    public function __construct() {
        $this->config = Configuracion::singleton();
        $enable_profiler = $this->config->get("enable_profiler");
        if($enable_profiler == true){
            $this->showProfiler();
        }
    }

    
    protected function showProfiler(){
        
        include __APPFOLDER__ . '/pages/profiler.php';
        
    }
    

}
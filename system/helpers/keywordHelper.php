<?php

class Keyword {

    
    public function __construct() {
        
    }

    public function generate($id_tabla,$id_ref,$contenido){
        
          // generamos las palabras claves
            $modelKeys = load::Modelo("sistema", "palabraTabla");
            $modelKeys->generarKeywords($contenido,$id_tabla,$id_ref);
        
        
    }
    
    
    public function mostrarSugerencia(){
        
        
        
        
    }
    
    
}
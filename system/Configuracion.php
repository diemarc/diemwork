<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
/**
 * Configuración general, creamos una clase Configuracion
 * creamos dos metodos uno para setear y otra para recuperar valores de una variable
 */

class Configuracion {
	
	private $variables;
	private static $instance;
	
	//Constructor
           
	private function __construct(){
		
		$this->variables = array();
	}
	
	//método para asignar variables, recibe dos parametros, nombre y su valor correspondiente a asignar
	
	public function set($nombre,$valor){
		
		if (!isset($this->variables[$nombre])) {
			
			$this->variables[$nombre] = $valor;
			
		}
	}
	
	// método para recuperar valor de una variable
	
	public function get($nombre){
		
		if(isset($this->variables[$nombre])){
			
			return $this->variables[$nombre];
		}
	
	}
	
	// método estático para el patrón singleton
	
	public static function singleton(){
		
		if (!isset(self::$instance)) {
			
			$c = __CLASS__;
			self::$instance = new $c;
			
		}
		
		return self::$instance;
		
	}
}
?>
<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
/**
 * Implementamos PDO para la abstracción a al acceso a la base de datos
 * Creamos una clase extendida de PDO (Epdo), para implementar patron singleton 
 * en la conexion.
 * nos aseguramos de que solo se instancie una conexcion, ahorramos importante 
 * recurso en el servidor.
 */
class Epdo extends PDO {

    private static $instance = null;

    /* constructor que realiza la conexion de manera abstracta utilizando 
     * mysql, utilizamos el
     * metodo get para recuperar valores definidos en conf.php
     */

    public function __construct() {
        $config = Configuracion::singleton();
        parent::__construct('mysql:host=' . $config->get('host') .
                ';port=' . $config->get('dbport') . ';dbname=' .
                $config->get('dbname'), $config->get('dbuser'), $config->get('dbpass'));
       
    }

    /**
     * Si ya esta instanciada crea una nueva instancia caso contraria nos 
     * devuelve la clase instanciada
     * @return instancia
     */
    public static function singleton() {

        if (self::$instance == null) {

            self::$instance = new self();
        }

        return self::$instance;
    }

}
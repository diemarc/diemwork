<?php
/*
 *---------------------------------------------------------------
 * DOCUMENT_ROOT 
 *---------------------------------------------------------------
/**
 * Configurar el sitio, hay que atender las 3 constantes
 * 1 __DOCUMENTROOT__ ; si existe un virtual host que apunte directamente a 
 * la carpeta application, dejar vacio, en el caso de que es un subdirectorio
 * dentro del virtualhost, hay que especificarlo.
 * 2 __COREFOLDER__;3 __APPFOLDER__
 */

define('__DOCUMENTROOT__', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT').'');

/*
 *---------------------------------------------------------------
 * CORE DEL SISTEMA
 *---------------------------------------------------------------

/**
 * carpeta donde se encuentran los archivos del core
 * siempre poner slash inicial y final
 */
define('__COREFOLDER__', __DOCUMENTROOT__. '/../system/');

/*
 *---------------------------------------------------------------
 * CARPETA DE APPLICATION
 *---------------------------------------------------------------
 *    
 * carpeta donde se encuentra Application,
 * la carpeta donde se aloja la aplicacion
 * siempre poner slash inicial y final
 */
define('__APPFOLDER__', __DOCUMENTROOT__ . '/');
/*
 * carpeta donde se encuentra los modulos de la aplicacion
 * HMVC
 */
define('__MODULEFOLDER__', __APPFOLDER__ . 'modulos/');

/*
 *---------------------------------------------------------------
 * ENTORNO DE LA APLICACION
 *---------------------------------------------------------------
/**
 * Reporte de errores
 * por defecto esta en modo desarrollo
 * posibles valores (desarrollo,produccion,testing)
 */
define('_ENTORNO_', 'desarrollo');

if (defined('_ENTORNO_')) {
    switch (_ENTORNO_) {
        case 'desarrollo':
            ini_set('display_errors', 1);
            error_reporting(-1);
            error_reporting(E_ALL);
            break;

        case 'testing':
        case 'produccion':
            error_reporting(0);
            break;

        default:
            exit('La aplicacion no tiene definido el entorno valido');
    }
}

/*
 *---------------------------------------------------------------
 * PREFIJOS 
 *---------------------------------------------------------------
/**
 * todas los nombres de los controladores tienen que tener el sufijo 
 * que se especifique aqui, el nombre de la clase obviamente tiene que estar
 * capitalizado
 * es case_sensitive
 */

define('_CONTROLLER_SUFIX_','_c');
define('_MODEL_SUFIX_','_m');

require_once( __COREFOLDER__
        . 'FrontControlador.php');
FrontControlador::main();

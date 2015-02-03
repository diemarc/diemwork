<?php
/**
 * Configuración de la web,seteamos las rutas de los modelos,vistas,controlador con el metodo set 
 * que está definido dentro de la clase configuración dentro del fichero Configuracion.php
 * implementamos el patron singleton, instanciamos la clase Configuracion y su metodo estatico singleton
 */

$config = Configuracion::singleton();

/*
 *---------------------------------------------------------------
 * FORMATO DE FECHAS 
 *---------------------------------------------------------------
 * 
 */
 
$config->set('fecha_hoy',strftime("%Y-%m-%d-%H-%M-%S",time()));
$config->set('date_format','DD-MM-YYYY');

/*
 *---------------------------------------------------------------
 * CONTROLADOR , MODULO Y ACCION POR DEFECTO
 *---------------------------------------------------------------
 * 
 */
// controlador por defecto
$config->set('default_controller','index');
// accion por defecto
$config->set('default_action','index');
// modulo por defecto
$config->set('default_module','modulos/sistema');
/* seccion de documentacion PDF*/
// ruta de plantillas
$config->set('plantilla_documentacion','template/documentacion');
// ruta del css
$config->set('css_documentacion','template/documentacion/estiloinformes');

/*
 *---------------------------------------------------------------
 * PROFILER 
 *---------------------------------------------------------------
 * Muestra uso de memorias y CPU que usa el script php
 */
$config->set("enable_profiler",false);

/*
 *---------------------------------------------------------------
 *BASES DE DATOS
 *---------------------------------------------------------------
 * 
 */
$config->set('host','');
$config->set('dbname','');
$config->set('dbuser','');
$config->set('dbpass','');
$config->set('dbport','');


?>
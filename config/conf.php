<?php
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
$config->set('enable_profiler',false);

/*
 *---------------------------------------------------------------
 * PLANTILLAS DE HTML 
 *---------------------------------------------------------------
 * Se define dos plantillas, una de la parte privada/administracion
 * en private_layout
 * 
 * En public_layout la plantilla para la parte publica,
 * la www
 */
$config->set('private_layout_folder','default');
$config->set('public_layout_folder','');

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

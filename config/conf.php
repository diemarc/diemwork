<?php
$config = Configuracion::singleton();

/*
 *---------------------------------------------------------------
 * SUEPRUSUARIO 
 *---------------------------------------------------------------
 * 
 */
$config->set('root_user','tau');
$config->set('root_password','5ef493b722c25a8292831d68657cb506b9d7ef45'); //invent*497 (sha1)

/*
 *---------------------------------------------------------------
 * LLAVE AES
 *---------------------------------------------------------------
 * Se utiliza para encryptar las constraseñas en mysql o en php
 */
$config->set('aes_key','vnaT497*_N');

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
 * PANTALLA DE LOGIN 
 *---------------------------------------------------------------
 * 
 */

$config->set('login_path',__APPFOLDER__.'pages/login/login.php');


/*
 *---------------------------------------------------------------
 * SESIONES
 *---------------------------------------------------------------
 * 
 */
$config->set('session_enabled',true);
$config->set('session_secure_word','%6oij178_po');
$config->set('session_name','_keranasess');


/*
 *---------------------------------------------------------------
 *BASES DE DATOS
 *---------------------------------------------------------------
 * 
 */
$config->set('host','localhost');
$config->set('dbname','kerana_db');
$config->set('dbuser','root');
$config->set('dbpass','darksky');
$config->set('dbport','3306');

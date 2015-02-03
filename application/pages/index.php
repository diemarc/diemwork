<?php
	// Preparar/verificar sesión segura
	session_cache_limiter('private');
	session_cache_expire(600000);
	session_start();
	
	require_once($_SERVER['DOCUMENT_ROOT'] ."/../config/app_config.inc");
	require_once($_SERVER['DOCUMENT_ROOT'] ."/../config/exceptions.inc");
	require_once($_SERVER['DOCUMENT_ROOT'] ."/../includes/securesession.class.php");
				
	$ss = new SecureSession();
	$ss->check_browser = true;
	$ss->check_ip_blocks = 2;
	$ss->secure_word = $sys_cgf_app['secure_word'];
	$ss->regenerate_id = true;
	if (!$ss->Check() || !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'])
	{
		header('Location: login.php');
		die();
	}
	
	header('Location: http://' .$_SERVER['HTTP_HOST'] .'/main.php');
?>

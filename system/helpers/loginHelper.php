<?php

require_once(__COREFOLDER__ . "libs/securesession.class.php");

class Login {

    public $config;

    public function __construct() {
        $this->config = Configuracion::singleton();
    }

    public function checkLogin() {

        session_cache_limiter('private');
        session_cache_expire(600000);
        session_start();

        $ss = new SecureSession();
        $ss->check_browser = true;
        $ss->check_ip_blocks = 2;
        $ss->secure_word = $this->config->get('secure_word');
        $ss->regenerate_id = true;
        if (!$ss->Check() || !isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            return false;
        } else {
            return true;
        }
    }

}

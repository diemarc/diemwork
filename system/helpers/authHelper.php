<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo') : "";
require_once(__COREFOLDER__ . 'libs/session/secureSessionHandler.php');

class Auth extends secureSessionHandler {

    protected $config, $login_path, $session, $model_user;
    public $logged;

    public function __construct() {
        parent::__construct();
        $this->session = new secureSessionHandler();
        $this->login_path = $this->config->get('login_path');
        $this->model_user = load::Model('sistema', 'usuario', '', true);
    }

    public function checkLogin() {

        $this->session->start();
        if (!$this->session->isValid(5)) {
            $this->session->destroy();
        }

        if ($this->session->get('logged_in') != 1 AND ! $this->session->isExpired()) {
            $this->showLoginPage();
        }
    }

    protected function showLoginPage($error = "") {

        include ($this->login_path);
        die;
    }

    private function isSuperUserLogin($username, $cryp_password) {

        $default_user = $this->config->get('root_user');
        $default_user_pass = $this->config->get('root_password');

        if ($username == $default_user) {
            if ($cryp_password == $default_user_pass) {
                $this->createSession($this->config->get('root_user'));
                return true;
            } else {
                $this->showLoginPage('Usuario y/o password incorrectos');
            }
        }
    }

    public function doLogin() {

        $username = filter_input(INPUT_POST, 'f_username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'f_password', FILTER_SANITIZE_SPECIAL_CHARS);
        $cryp_password = sha1($password);


        // Comrobamos si es es root
        if ($this->isSuperUserLogin($username, $cryp_password)) {
            return true;
        }
        // comprobamos si el usuario existe en la base de datos

        $rsUser = $this->model_user->seleccionarUsuarioPass($username, $password);
        if (!$rsUser) {
            $this->showLoginPage('El usuario no existe en la base de datos');
        } else if ($rsUser['id_estado'] != 1) {
            $this->showLoginPage('El usuario existe pero est&aacute; inactivo');
        } else {
            $this->createSession($rsUser['usuario']);
            return true;
        }
    }

    public function createSession($username) {
        $this->session->start();
        $this->session->put('logged_in', 1);
        $this->session->put('logged_username', $username);
        $this->logged = $this->session->get('logged_in');
        $this->checkLogin();
    }

    public function closeSession() {
        $this->session->start();
        $this->session->destroy();
        return true;
    }

}

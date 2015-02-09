<?php

(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo') : "";

class Usuario_m extends ModeloBase {

    protected $aes_key;

    public function __construct() {

        $this->_table = 'diem_usuario';
        $this->_idtable = 'id_usuario';
        $this->_idkey = 'id_usuario';
        $this->conf = Configuracion::singleton();
        $this->aes_key = $this->conf->get('aes_key');
        parent::__construct();
    }

    public function seleccionarUsuarioPass($username, $password) {

        $query = "SELECT CONCAT_WS(' ',A.nombres,A.apellidos) AS usuario_nombre,"
                . " A.usuario,A.id_estado"
                . " FROM " . $this->_table . " A "
                . " WHERE A.usuario = :username "
                . " AND A.password = AES_ENCRYPT('$password','$this->aes_key') ";
        try {
            $rs = $this->_db->prepare($query);
            $rs->bindParam(':username', $username, PDO::PARAM_STR);
            $rs->execute();
        } catch (PDOException $e) {
            throw New Exception($e);
        }
        $row = $rs->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

}

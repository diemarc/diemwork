<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
class Usuario_m extends ModeloBase {

    public function __construct() {

        $this->_table = "sys_base_tabla";
        $this->_idtable = "id_tabla";
        $this->_idkey = "";

        parent::__construct();
    }

    public function seleccionarTablas() {
        return $this->seleccionarByQuery(" SHOW TABLES ");
    }

    public function insertarTablaBase($tabla) {

        $query = " INSERT INTO " . $this->_table
                . " (tabla) "
                . " VALUES "
                . " (:tabla)";
        try {
            $rs = $this->_db->prepare($query);
            $rs->bindParam(":tabla", $tabla);
            $rs->execute();
        } catch (PDOException $e) {
            $error = New Exception($e) . "<hr>" . $query;
            Exceptions::MostrarError("Error en " . __CLASS__ . " en el metodo " . __FUNCTION__, $error);
        }
    }

    public function seleccionarTableByName($tablename) {

        if (empty($tablename)) {
            die("Error de parametros");
        }

        $query = "SELECT * FROM " . $this->_table . " WHERE tabla = :tableName";

        try {
            $rs = $this->_db->prepare($query);
            $rs->bindParam(":tableName", $tablename, PDO::PARAM_STR);
            $rs->execute();
        } catch (PDOException $e) {
            throw New Exception($e);
            return $e;
        }
        return $rs->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdTabla() {

        $rs = $this->seleccionarTableByName($this->_table);
        return $rs["id_tabla"];
    }

    public function showColumns($tablename) {

        $query = " SHOW COLUMNS FROM $tablename ";

        try {
            $rs = $this->_db->prepare($query);
            $rs->bindParam(":tableName", $tablename, PDO::PARAM_STR);
            $rs->execute();
        } catch (PDOException $e) {
            $error = New Exception($e) . "<hr>" . $query;
            Exceptions::MostrarError("Error en " . __CLASS__ . " en el metodo " . __FUNCTION__, $error);
        }
        return $rs->fetchAll();
    }

    public function showTotalReg($tablename) {

        $query = " SELECT COUNT(*)AS num_reg FROM $tablename ";

        try {
            $rs = $this->_db->prepare($query);
            $rs->execute();
        } catch (PDOException $e) {
            $error = New Exception($e) . "<hr>" . $query;
            Exceptions::MostrarError("Error en " . __CLASS__ . " en el metodo " . __FUNCTION__, $error);
        }
        return $rs->fetch(PDO::FETCH_ASSOC);
    }

}


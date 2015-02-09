<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
abstract class ModeloBase {

    protected $_db;
    protected $_idtable;
    protected $_table;
    protected $_query;
    protected $_idkey;
    public $tableId;

    public function __construct() {
        $this->_db = Epdo::singleton();
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    }

 /*
 *---------------------------------------------------------------
 * METODOS GENERALES
  * 
 *---------------------------------------------------------------
 */
 // Seleccionar de la tabla definida mediante condicion where, devuelve un resultado
    
    public function selectWhere($where) {

        $this->_query = "SELECT  ";
        try {
            $rs = $this->_db->prepare($this->_query);
            $rs->execute();
        } catch (PDOException $e) {
            throw New Exception($e);
            return $e;
        }
        $row = $rs->fetch(PDO::FETCH_ASSOC);

        return $row["num_reg_query"];
    }
    
    
    
    
    
    /**
     * SETTER'S
     * @return type
     */
    public function setQuery($query) {
        $this->_query = $query;
    }

    /**
     * GETTER'S
     * @return type
     */
    public function getQuery() {
        return ($this->_query == NULL) ? "query null" : $this->_query;
    }

    public function reiniciarAutoIncrement() {

        $query = " ALTER TABLE ".$this->_table." auto_increment=1";

        try {
            $rs = $this->_db->prepare($query);
            $rs->execute();
        } catch (PDOException $e) {
            $error = New Exception($e) . "<hr>" . $query;
            Exceptions::MostrarError("Error en " . __CLASS__ . " en el metodo " . __FUNCTION__, $error);
        }
    }

    // consultas

    public function seleccionarTodo() {

        $this->_query = " SELECT * FROM " . $this->_table
                . " WHERE " . $this->_idtable . " IS NOT NULL "
                . " ORDER BY " . $this->_idtable . " DESC";
        //die($this->_query);
        try {
            $rs = $this->_db->prepare($this->_query);
            $rs->execute();
        } catch (PDOException $e) {
            $error = New Exception($e)."<hr>".$this->_query;
            Exceptions::MostrarError("Error en ".__CLASS__." metodo: ".__FUNCTION__, $error);
        }
        return $rs->fetchAll();
    }

    public function getLastInsertId() {

        $this->_query = " SELECT MAX(" . $this->_idtable . ") AS MAX_ID "
                . " FROM " . $this->_table . " WHERE " . $this->_idtable . " IS NOT NULL ";
        try {
            $rs = $this->_db->prepare($this->_query);
            $rs->execute();
        } catch (PDOException $e) {
            $error = New Exception($e);
            Exceptions::MostrarError("Error en la consulta SQL de obtener el ultimo id", $error);
        }
        $row = $rs->fetch(PDO::FETCH_ASSOC);

        return $row["MAX_ID"];
    }

    public function contarRegistrosTabla() {
        try {
            $rs = $this->_db->prepare($this->_query);
            $rs->execute();
        } catch (PDOException $e) {
            $error = New Exception($e);
            Exceptions::MostrarError("Error en la consulta SQL de contar registros ", $error);
        }
        return $rs->rowCount();
    }

    public function contarRegistroQuery($key_count, $query) {

        $this->_query = "SELECT COUNT(A." . $key_count . ") AS num_reg_query FROM (" . $query . ")A";
        try {
            $rs = $this->_db->prepare($this->_query);
            $rs->execute();
        } catch (PDOException $e) {
            throw New Exception($e);
            return $e;
        }
        $row = $rs->fetch(PDO::FETCH_ASSOC);

        return $row["num_reg_query"];
    }

    public function seleccionarByQuery($query) {

        $this->_query = $query;

        try {
            $rs = $this->_db->prepare($this->_query);
            $rs->execute();
        } catch (PDOException $e) {
            throw New Exception($e);
        }
        return $rs->fetchAll();
    }

    /* --------------------------------------------------------------------------/
     * INSERTS,UPDATES,DELETES
      -------------------------------------------------------------------------- */

    public function insertarRegistroBind($array) {

        $fields = $this->parseValues($array);

        $insert = "INSERT INTO " . $this->_table . " $fields ";
        try {
            $rs = $this->_db->prepare($insert);
            $this->bindPdo($rs, $array, PDO::PARAM_STR);
            $rs->execute();
            return true;
        } catch (PDOException $e) {
            //throw New Exception($e);
            return $e;
        }
    }

    private function parseValues($array) {

        $values = "";
        $fields = "";
        foreach ($array as $f => $v) {
            if ($fields != "") {
                $fields .= ", ";
                $values .= ", ";
            }
            $fields .= $f;
            $values .= ":" . $f . "";
        }
        $fields = "(" . $fields . ") VALUES (" . $values . ")";

        return $fields;
    }

    private function bindPdo($rs, $array, $type) {

        $values = "";
        foreach ($array as $f => $v) {
            $values .= ":" . $f;

            $rs->bindParam("$values", $v, $type);
        }
    }

    /* tabla base */

    public function seleccionarTableByName($tablename) {

        if (empty($tablename)) {
            die("Error de parametros = " . __FUNCTION__);
        }

        $query = "SELECT * FROM sys_base_tabla  WHERE tabla = :tableName";

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

    public function eliminarTabla() {

        $query = " DELETE FROM  " . $this->_table;

        try {
            $rs = $this->_db->prepare($query);
            $rs->execute();
        } catch (PDOException $e) {
            $error = New Exception($e) . "<hr>" . $query;
            Exceptions::MostrarError("Error en " . __CLASS__ . " en el metodo " . __FUNCTION__, $error);
        }
    }

    public function setIdTabla() {

        $rs = $this->seleccionarTableByName($this->_table);
        $this->tableId = $rs["id_tabla"];
    }

    public function getIdTabla() {
        $this->setIdTabla();
        return $this->tableId;
    }

}

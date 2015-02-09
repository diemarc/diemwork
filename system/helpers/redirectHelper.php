<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
class Redirect {

    static function cargarControlador($modulo,$controlador,$metodo, $params = "") {

        $par = "";
        //__APPFOLDER__ . "modulos" . "/"
        $destino = "/index.php?mod=$modulo&c=".$controlador."&a=".$metodo;
        if (!empty($params)) {
            foreach ($params as $k => $p) {
                $par = $par . $k . "=" . $p . "&";
            }
        }
        $url = $destino . "&" . $par;
        header("Location: http://${_SERVER['HTTP_HOST']}$url");
    }

}

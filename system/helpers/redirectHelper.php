<?php

class Redirect {


    static function cargarControlador($modulo,$controlador,$metodo, $params = "") {

        $par = "";
        $destino = "/application/index.php?mod=" . $modulo . "&c=".$controlador."&a=".$metodo;
        if (!empty($params)) {
            foreach ($params as $k => $p) {
                $par = $par . $k . "=" . $p . "&";
            }
        }
        $url = $destino . "&" . $par;
        header("Location: http://${_SERVER['HTTP_HOST']}$url");
    }

}

?>

<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
class Vista {

    protected $mobile;
    private $_device_type;

    public function __construct() {
        $this->mobile = new Mobile_Detect;
        $this->_device_type = ($this->mobile->isMobile() ?
                        ($this->mobile->isTablet() ? 'tablet' : 'movil') : 'pc');


        $config = Configuracion::singleton();
        $this->_app_path = $config->get('application_path');
    }

    public function cargarVista($modulo, $vista, $variables = "", $load_header = true) {
        $ruta = __APPFOLDER__ . "modulos" . "/"
                . $modulo . "/v/" . $this->_device_type . "/" . $vista . ".php";

// controlamos que exista la ruta de la vista

        if (file_exists($ruta) == false) {
            $descripcion = "No se puede cargar la vista:<br><b> $vista</b>"
                    . "<br>Ruta completa =<b>$ruta</b>";
            Exceptions::MostrarError("Error al cargar vista", $descripcion);
        }

        if (is_array($variables)) {
            foreach ($variables as $key => $valor) {
                $$key = $valor;
            }
        }


        if ($load_header) {
            require_once(__APPFOLDER__ 
                    . "template/htmlHeader.php");
        }
        include($ruta);
        require_once(__APPFOLDER__ . "template/footer.php");
    }

}
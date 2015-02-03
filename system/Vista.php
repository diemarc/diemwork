<?php
(!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo'):"";
class Vista {

    protected $mobile;
    private $_device_type;
    protected $_config;

    public function __construct() {
        $this->mobile = new Mobile_Detect;
        $this->_device_type = ($this->mobile->isMobile() ?
                        ($this->mobile->isTablet() ? 'tablet' : 'movil') : 'pc');

        $this->_config = Configuracion::singleton();
    }

    public function cargarVista($modulo, $vista, $variables = "", $type="default") {
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

        $layout_folder = $this->getFolderLayout($type);
        
        // incluimos e encabezado html
        require_once(__APPFOLDER__ 
                    . 'layouts/'.$layout_folder.'/_htmlHeader.php');
        
        include($ruta);
        
        // incluimos el footer
         require_once(__APPFOLDER__ 
                    . 'layouts/'.$layout_folder.'/_htmlFooter.php');
        
    }
    
    private function getFolderLayout($type){
        switch ($type) {
            case 'default':
                $folder = $this->_config->get('private_layout_folder');

                break;
            case 'public':
                $folder = $this->_config->get('public_layout_folder');

                break;
        }
        
        return $folder;
    }

}
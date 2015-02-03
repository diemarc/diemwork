<?php

class Pdf {

    public $config;
    // path general de la documentacion
    protected $path_tpl_documentacion;
    // ruta del estilo css por defecto
    protected $path_css_documentacion;
    protected $nombre_documento;
    protected $nombre_empresa;
    protected $plantilla;
    protected $tecnico;
    protected $fecha_evaluacion;
    protected $contratante;
    protected $nombre_contratante;
    protected $logo_contratante; 
    
    public function __construct() {
        $this->config = Configuracion::singleton();
        $this->path_tpl_documentacion = $this->config->get('plantilla_documentacion');
        $this->path_css_documentacion = $this->config->get('css_documentacion');
        require_once($_SERVER['DOCUMENT_ROOT'] . "/../system/libs/html2pdf/html2pdf.class.php");
    }

    /**
     * 
     * @param type $variables array que contiene las variables a incluir en el pdf
     * @param type $plantilla string la plantilla que queremos usar
     */
    public function crearPdf($variables, $portada = true, $mode = "D", $css = "") {

        // activamos el buffer de de almacenamiento para la salida
        ob_start();

        // procesa las variables para que esten disponible en la plantilla pdf
        if (is_array($variables)) {
            foreach ($variables as $key => $valor) {
                $$key = $valor;
            }
        }

        // construimos la ruta de la plantilla
        $ruta_plantilla = $this->path_tpl_documentacion . "/" . $this->getPlantilla();

        // constriumos la ruta del estilo css
        $estilo_css = (empty($css)) ? $this->path_css_documentacion : $css;
        $ruta_css = $estilo_css . ".php";

        // incluimos el estilo css y la plantilla y la portada
        include($ruta_css);
        if ($portada) {
            $this->crearPortada();
        }
        include($ruta_plantilla);

        // obtenemos la informacion del bufer de almacenamiento
        $content = ob_get_clean();

        // creamos el PDF
        $html2pdf = new HTML2PDF('P', 'A4', 'es', false, 'ISO-8859-15');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output("$this->nombre_documento.pdf", "$mode");
    }
/**
 * Crea la portada para cada documento
 */
    public function crearPortada() {
        $nombre_empresa = $this->getNombreEmpresa();
        $nombre_documento = $this->getNombreDocumento();
        $nombre_tecnico = $this->tecnico;
        $fecha_evaluacion = $this->fecha_evaluacion;
        include($this->path_tpl_documentacion . "/portada.php");
    }
/**
 * setter
 * @param type $empresa
 */
    public function setNombreEmpresa($empresa) {
        $this->nombre_empresa = $empresa;
    }

    public function setNombreDocumento($nombre_documento) {
        $this->nombre_documento = $nombre_documento;
    }

    public function setPlantilla($plantilla) {
        $this->plantilla = $plantilla;
    
    }
    
    public function setTecnico($tecnico) {
        $this->tecnico = $tecnico;
    
    }
    public function setFechaEvaluacion($fecha) {
        $this->fecha_evaluacion = $fecha;
    
    }
    

    public function getNombreEmpresa() {
        return $this->nombre_empresa;
    }

    public function getNombreDocumento() {
        return $this->nombre_documento;
    }
    
    public function getPlantilla(){
        return $this->plantilla;
    }

}
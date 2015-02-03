<?php

/* * *********************************************************************************
 * Clase para subir fotos y redimencionar, utilizo una clase externa (resize.class.php)
 * @autor diemarc.os@gmail.com
 * @version 1.0
 * @GPL - 2011

  nota:
 * cualquier error o mejora en el script favor comunicar a direccion de correo,
 * "la información es poder"
 * @enjoy the life, enjoy programming....
 * *********************************************************************************** */

// Clase para la manipulación de imagenes, necesita de la libreria gd2 o gd
include("resize.class.php");

class Upload {
    /*
     * ruta donde se guarda la imagen
     * @string
     */

    public $full_path;

    /*
     * ruta donde se guarda el thumbnail
     * @string
     */
    public $full_path_th;

    /*
     * nombre de la carpeta
     * @string
     */
    public $folder;

    /*
     * nombre de la carpeta del thumbnail
     * @string
     */
    public $folder_th;


    /*
     * ancho para el  thumbnail
     * @int
     */
    public $width_th;

    /*
     * alto para el  thumbnail
     * @int
     */
    public $height_th;

    /*
     * nombre temporal de la imagen
     * @string
     */
    public $tmp_name;

    /*
     * nombre de la imagen
     * @string
     */
    public $name;

    /*
     * renombre de la imagen con md5
     * @string
     */
    public $rename;

    /*
     * renombre de la imagen del thumbnail con md5
     * @string
     */
    public $rename_th;

    /*
     * extension de la imagen
     * @string
     */
    public $ext;

    /*
     * extensiones permitidas
     * @array
     */
    public $allow_list = array("jpeg", "gif", "png", "jpg");

    /*
     * 
     */
    
    protected $resize;

    public function __construct() {
        
        // cargamos el resize helper
        $this->resize= load::Helper("resize");
        
        $this->name = strtolower($_FILES[imagen][name]);
        $this->tmp_name = $_FILES[imagen][tmp_name];
        $this->ext = end(explode('.', $this->name)); // obtenemos la extension de la imagen
        $this->comprobarExtension();
        $this->comprobarImagen();
        
        
    }

    /*
     * Setter para la carpeta donde queremos subir las fotos
     */

    public function setFolder($folder) {
        $this->folder = $folder;
        $this->setFullPath();
    }

    /*
     * Armamos la ruta completa, utilizamos la encriptacion md5 para generar el nombre de la foto
     * @return void
     */

    protected function setFullPath() {

        $this->rename = md5($this->name); // renombramos el nombre a un algoritmo md5

        $this->full_path = $this->folder . "/" . $this->rename . "." . $this->ext;
    }

    public function printName(){
        return $this->rename . "." . $this->ext;;
    }
    /*
     * Subimos la imagen
     */

    public function uploadImg() {
        if (move_uploaded_file($this->tmp_name, $this->full_path)) {
            chmod($this->full_path, 0777);
            return true;
        } else {
            return false;
        }
    }

    public function deleteImg() {
        if (!unlink($this->full_path)) {
            trigger_error("No se pudo eliminar la imagen");
        }
    }

     public function deleteImgThumb() {
        if (!unlink($this->full_path_th)) {
            trigger_error("No se pudo eliminar el thumbnail de la imagen");
        }
    }

    /*
     * Comprueba si la extension esta dentro de la lista permitida
     * @return
     */

    protected function comprobarExtension() {
        if (!in_array($this->ext, $this->allow_list)) {
            trigger_error("Tipo de archivo no permitido" . $this->ext);
            exit();
        }
    }

    /*
     * Comprueba si es una imagen
     * @return
     */

    protected function comprobarImagen() {
        $imageinfo = getimagesize($this->tmp_name);
        if ($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo)) {
            trigger_error("El archivo seleccionado no parece ser una imagen");
            exit(0);
        }
    }

    /**     * *********************************************************************
     * Metodos para la creación de thumbnails
     * ********************************************************************** */
    /*
     * Armamos la ruta completa, para la generacion del thumbnail
     * @return void
     */

    /*
     * Setter para la carpeta donde queremos subir las fotos para el thumbnail
     */

    public function setFolderTh($folder_th) {
        $this->folder_th = $folder_th;
        $this->setFullPathth();
    }

    protected function setFullPathth() {
        $this->full_path_th = $this->folder_th . "/" . $this->rename . "." . $this->ext;
    }

    /*
     * Setter para el ancho y alto para el thumbnail
     */

    public function setWidthTh($width_th="") {
        $this->width_th = $width_th;
    }

    public function setHeightTh($height_th="") {
        $this->height_th = $height_th;
    }

    /*
     * Crea el thumbnail
     */

    public function crearThum() {

        $thumb = new thumbnail($this->full_path);

        if (isset($this->height_th)) {
            $thumb->size_height($this->height_th);
        }
        if (isset($this->width_th)) {
            $thumb->size_width($this->width_th);
        }
        $thumb->jpeg_quality(80);

        $thumb->save($this->full_path_th);
    }

}
?>

<?php
##############################################
# Shiege Iseng Resize Class
# 11 March 2003
# shiegege_at_yahoo.com
# View Demo :
#   http://shiege.com/scripts/thumbnail/
/*############################################
Sample :
$thumb=new thumbnail("./shiegege.jpg");			// generate image_file, set filename to resize
$thumb->size_width(100);				// set width for thumbnail, or
$thumb->size_height(300);				// set height for thumbnail, or
$thumb->size_auto(200);					// set the biggest width or height for thumbnail
$thumb->jpeg_quality(75);				// [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75
$thumb->show();						// show your thumbnail
$thumb->save("./huhu.jpg");				// save your thumbnail to file
----------------------------------------------
Note :
- GD must Enabled
- Autodetect file extension (.jpg/jpeg, .png, .gif, .wbmp)
  but some server can't generate .gif / .wbmp file types
- If your GD not support 'ImageCreateTrueColor' function,
  change one line from 'ImageCreateTrueColor' to 'ImageCreate'
  (the position in 'show' and 'save' function)
 -----------------------------------------------
 Note 2:
 - @diemarc.os@gmail.com -> i do modification in a construct method to adjust to PHP5, and methods
 * 2011
*/############################################


class thumbnail {

    public $img;
    

    public function __construct($imgfile) {

        $this->img["format"] = ereg_replace(".*\.(.*)$", "\\1", $imgfile);
        $this->img["format"] = strtoupper($this->img["format"]);
        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {
            //JPEG
            $this->img["format"] = "JPEG";
            $this->img["src"] = imagecreatefromjpeg($imgfile);
        } elseif ($this->img["format"] == "PNG") {
            //PNG
            $this->img["format"] = "PNG";
            $this->img["src"] = ImageCreateFromPNG($imgfile);
        } elseif ($this->img["format"] == "GIF") {
            //GIF
            $this->img["format"] = "GIF";
            $this->img["src"] = ImageCreateFromGIF($imgfile);
        } elseif ($this->img["format"] == "WBMP") {
            //WBMP
            $this->img["format"] = "WBMP";
            $this->img["src"] = ImageCreateFromWBMP($imgfile);
        } else {
            //DEFAULT
            echo "Archivo no soportado".$this->img["format"];
            exit();
        }
        @$this->img["lebar"] = imagesx($this->img["src"]);
        @$this->img["tinggi"] = imagesy($this->img["src"]);

        $this->img["quality"] = 75;
    }

    public function size_height($size=100) {
        //height
        $this->img["tinggi_thumb"] = $size;
        @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"] / $this->img["tinggi"]) * $this->img["lebar"];
    }

    public function size_width($size=100) {
        //width
        $this->img["lebar_thumb"] = $size;
        @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"] / $this->img["lebar"]) * $this->img["tinggi"];
    }

    public function size_auto($size=100) {
        //size
        if ($this->img["lebar"] >= $this->img["tinggi"]) {
            $this->img["lebar_thumb"] = $size;
            @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"] / $this->img["lebar"]) * $this->img["tinggi"];
        } else {
            $this->img["tinggi_thumb"] = $size;
            @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"] / $this->img["tinggi"]) * $this->img["lebar"];
        }
    }

    public function jpeg_quality($quality=100) {
        //jpeg quality
        $this->img["quality"] = $quality;
    }

    public function show() {
        //show thumb
        @Header("Content-Type: image/" . $this->img["format"]);

        
        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);
        @imagecopyresized($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {
            //JPEG
            imageJPEG($this->img["des"], "", $this->img["quality"]);
        } elseif ($this->img["format"] == "PNG") {
            //PNG
            imagePNG($this->img["des"]);
        } elseif ($this->img["format"] == "GIF") {
            //GIF
            imageGIF($this->img["des"]);
        } elseif ($this->img["format"] == "WBMP") {
            //WBMP
            imageWBMP($this->img["des"]);
        }
    }

    public function save($save="") {
        //save thumb
        if (empty($save))
            $save = strtolower("./thumb." . $this->img["format"]);
        
        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);
        @imagecopyresized($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {
            //JPEG
            imageJPEG($this->img["des"], "$save", $this->img["quality"]);
        } elseif ($this->img["format"] == "PNG") {
            //PNG
            imagePNG($this->img["des"], "$save");
        } elseif ($this->img["format"] == "GIF") {
            //GIF
            imageGIF($this->img["des"], "$save");
        } elseif ($this->img["format"] == "WBMP") {
            //WBMP
            imageWBMP($this->img["des"], "$save");
        }
    }

}
?>
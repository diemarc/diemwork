<?php

class String {

    public $config;

    public function __construct() {
        $this->config = Configuracion::singleton();
    }

    public function extraerPalabrasClaves($string, $encoding = 'UTF-8') {
        $string = trim(strip_tags(html_entity_decode(urldecode($string))));
        if (empty($string)) {
            return false;
        }

        $extras = array(
            'p' => array('ante', 'bajo', 'con', 'contra', 'desde', 'durante', 'entre',
                'hacia', 'hasta', 'mediante', 'para', 'por', 'pro', 'segun',
                'sin', 'sobre', 'tras', 'via', 'del', 'son', 'de'
            ),
            'a' => array('los', 'las', 'una', 'unos', 'unas', 'este', 'estos', 'ese',
                'esos', 'aquel', 'aquellos', 'esta', 'estas', 'esa', 'esas',
                'aquella', 'aquellas', 'usted', 'nosotros', 'vosotros',
                'ustedes', 'nos', 'les', 'nuestro', 'nuestra', 'vuestro',
                'vuestra', 'mis', 'tus', 'sus', 'nuestros', 'nuestras',
                'vuestros', 'vuestras','la','le'
            ),
            'o' => array('esto', 'que'),
        );

        $string = mb_strtolower((string) $string, $encoding);
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode('âàåáäèéêëïîìíôöòóúûüùñ'), "aaaaaeeeeiiiioooouuuun");
        if (preg_match_all('/\pL{4,}/s', $string, $m)) {
            $m = array_diff(array_unique($m[0]), $extras['p'], $extras['a'], $extras['o']);
        }
        return $m;
    }

}
<?php

class Date {

    public $config;
    
    public function __construct() {
        $this->config = Configuracion::singleton();
    }

    public function dbDate($strdate) {
        if ($strdate == "")
            return "";
        else {
            $format = $this->config->get('date_format');
            $format = strtoupper($format);
            if (($p = strpos($format, 'YYYY')) !== false)
                $year = substr($strdate, $p, 4);
            else
                $year = "0000";
            if (($p = strpos($format, 'MM')) !== false)
                $month = substr($strdate, $p, 2);
            else
                $month = "00";
            if (($p = strpos($format, 'DD')) !== false)
                $day = substr($strdate, $p, 2);
            else
                $day = "00";
            if (($p = strpos($format, 'HH')) !== false)
                $hour = substr($strdate, $p, 2);
            else
                $hour = "00";
            if (($p = strpos($format, 'MI')) !== false)
                $minute = substr($strdate, $p, 2);
            else
                $minute = "00";
            if (($p = strpos($format, 'SS')) !== false)
                $second = substr($strdate, $p, 2);
            else
                $second = "00";

            if ($year == "")
                $year = "0000";
            if ($month == "")
                $month = "00";
            if ($day == "")
                $day = "00";
            if ($hour == "")
                $hour = "00";
            if ($minute == "")
                $minute = "00";
            if ($second == "")
                $second = "00";

            return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":" . $second;
        }
    }

}
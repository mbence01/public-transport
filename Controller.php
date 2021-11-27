<?php

class Controller {
    public static function get($pagename) {
        if(!file_exists("routes.cfg"))
            return "sites/404.html";

        $f = fopen("routes.cfg", "r");

        while(($line = fgets($f)) !== false) {
            $str = explode(":", $line);

            if($str[0] != $pagename)
                continue;

            if(file_exists($str[1]))
                return $str[1];
            return "sites/404.html";
        }
        return "sites/404.html";
    }
}

?>
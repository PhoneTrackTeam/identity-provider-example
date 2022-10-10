<?php

namespace IdPExample\Helper;

class Utils
{
    public static function view($view, $data = [], $path = '/View')
    {
            ob_start();

            $view = str_replace('.', '/', $view);
            $view = dirname(__DIR__) . "{$path}/{$view}.phtml";

            if (!file_exists($view)) {
                return "view not exist.";
            }
            
            extract($data);
            require_once $view;
        
            return ob_get_clean();
    }

    public static function redirect($location) {
        header("Location: $location");
        exit;
    }
}

<?php

namespace App\Controllers;

class BaseController {

    protected $viewPath = '';
    protected $method = 'index';
    protected $viewParams = [];
    
    public function __construct(){
        // Set default view path if not specified
        if ( ! $this->viewPath ) { 
            $classname = get_called_class();
            $this->viewPath = str_replace("Controller", '', str_replace("App\\Controllers\\", '', $classname ));
        };
    }

    public static function __callStatic ($method, $arg) {
        $obj = new static;
        $result = call_user_func_array (array ($obj, $method), $arg);
        if (method_exists ($obj, $method))
            return $result;
        return $obj;
    }

    protected static function loadView ($view = '', $params = [], $layout = 'main') {

        // Extract parameters to make them available in the view
        extract($params);
        
        // Start output buffering to capture view content
        ob_start();
        include BASE_DIR . "/views/$view.php";
        $content = ob_get_contents();
        ob_end_clean();

        // Load the layout file
        $layout = BASE_DIR . "/views/_layout/$layout.php";

        if (file_exists($layout)) {
            include $layout;
        } else {
            echo $content;
        }
    }

    protected static function redirect($url, $code = 302) {
        // Redirect to specified URL with optional HTTP status code
        header("Location: " . $url, true, $code);
        exit();
    }
}
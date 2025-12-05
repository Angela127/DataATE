<?php

//load config
require_once '../config/config.php';

//autoload core libraries
spl_autoload_register(function ($className)
{
    //check in core
    $corePath = '../app/core/' . $className . '.php';
    if(file_exists($corePath)){
        require_once $corePath;
        return;
    }

    //check in controllers
    $controllerPath = '../app/controllers/' . $className . '.php';
    if(file_exists($controllerPath)){
        require_once $controllerPath;
        return;
    }

    //check in models
    $modelPath = '../app/models/' . $className . '.php';
    if(file_exists($modelPath)){
        require_once $modelPath;
        return;
    }



});


/* Simple Router
 Parses the URL to determine controller, method and parameters.
*/

class Router{
    protected $controller = 'CustomerController';  //default controller
    protected $method= 'index';  //default method
    protected $params = [];

    public function _new()
    {
        $url = $this->parseUrl();

        //1, Controller
        //check if controller file exists (try both singular and as-is)
        if(isset($url[0])) {
            $controllerName = ucwords($url[0]);
            
            // Try exact name first (e.g., "tasks" -> "TasksController")
            if(file_exists('../app/controllers/' . $controllerName . 'Controller.php')){
                $this->controller = $controllerName . 'Controller';
                unset($url[0]);
            }
            // Try singular form (e.g., "tasks" -> "TaskController")
            elseif(file_exists('../app/controllers/' . rtrim($controllerName, 's') . 'Controller.php')){
                $this->controller = rtrim($controllerName, 's') . 'Controller';
                unset($url[0]);
            }
        }

        //instantiate the controller
        $this->controller = new $this->controller;

        //2. method (action)
        //Reindex array after unsetting
        $url = array_values($url);
        
        //check if method exists in the controller
        if(isset($url[0]) && method_exists($this->controller, $url[0])){
            $this->method = $url[0];
            unset($url[0]);
        }

        //3. parameters
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
        
    }

    //http:??mvc-pdo-crud.test/books/edit/5

    public function parseUrl()
    {
        if(isset($_SERVER['REQUEST_URI'])){
            $url = $_SERVER['REQUEST_URI'];
            
            // Remove query string if present
            $url = strtok($url, '?');
            
            // Get the base path (project folder + public)
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
            $basePath = dirname($scriptName);
            
            // Remove the base path from URL
            if ($basePath !== '/' && $basePath !== '\\') {
                $url = substr($url, strlen($basePath));
            }
            
            // Clean up the URL
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = ltrim($url, '/');
            
            if (empty($url)) {
                return [];
            }
            
            $url = explode('/', $url);
            return $url;
        }

        return [];
    }
}

//Let's go!
$router = new Router();
$router -> _new();
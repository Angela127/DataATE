<?php

class Controller{

    //helper to load a view
    //$data is used to pass variable to the view
    public function view($view, $data =[])
    {
        extract($data);

        $viewPath = '../app/views/' . $view . '.php';

        if(file_exists($viewPath))
        {
            //start output buffering
            ob_start();

            //include the view file
            require $viewPath;

            //get the buffered content
            $content=ob_get_clean();

            //include the main layout
            require '../app/views/layout.php';

        }else{
            die('View does not exists: ' . $viewPath);
        }
    }

    //helper to set a flash message
    public function setFlash($message, $type = 'success')
    {
        $_SESSION['flash']=[
            'message' =>$message,
            'type' =>$type
        ];
    }

    //helper to redirect
    public function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
}
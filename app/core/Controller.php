<?php
namespace App\core;

class Controller{
    public function view($view,$data=[]){
        extract($data);
        require __DIR__ ."/../views/layouts/header.php";
            $viewPath = __DIR__ . "/../views/{$view}.php";
        if (!file_exists($viewPath)) {
            die("View file not found: {$view}.php");
        }
        require_once $viewPath;

    }
    public function render($view,$data=[]){
         extract($data);
            $viewPath = __DIR__ . "/../views/{$view}.php";
        if (!file_exists($viewPath)) {
            die("View file not found: {$view}.php");
        }
        require_once $viewPath;

    }
   

}
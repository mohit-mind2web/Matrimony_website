<?php 
 require_once __DIR__  .'/../app/config/bootstrap.php';

use App\controllers\AuthController;
use App\controllers\DashboardController;
use App\controllers\ProfilecreateController;
use App\core\Router;
 session_start();
 $router=new Router();

 $router->get('/register',[AuthController::class,'registerform']);
  $router->post('/register',[AuthController::class,'register']);
   $router->get('/login',[AuthController::class,'loginform']);
  $router->post('/login',[AuthController::class,'login']);
    $router->get('/logout',[AuthController::class,'logout']);
  $router->get('/user/dashboard',[DashboardController::class,'index']);
  $router->get('/user/profilecreate',[ProfilecreateController::class,'index']);

  $router->dispatch();

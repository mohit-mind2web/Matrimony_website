<?php 
 require_once __DIR__  .'/../app/config/bootstrap.php';

use App\controllers\AuthController;
use App\controllers\MatchesController;
use App\controllers\ProfilecreateController;
use App\controllers\ProfileviewController;
use App\core\Router;
 session_start();
 $router=new Router();

 $router->get('/register',[AuthController::class,'registerform']);
  $router->post('/register',[AuthController::class,'register']);
   $router->get('/login',[AuthController::class,'loginform']);
  $router->post('/login',[AuthController::class,'login']);
    $router->get('/logout',[AuthController::class,'logout']);
  $router->get('/user/matches',[MatchesController::class,'index']);
  $router->get('/user/profilecreate',[ProfilecreateController::class,'index']);
  $router->post('/user/profilecreate',[ProfilecreateController::class,'profile']);

  $router->get('/user/profileview',[ProfileviewController::class,'profileview']);

  $router->dispatch();

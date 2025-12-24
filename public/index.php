<?php
require_once __DIR__  . '/../app/config/bootstrap.php';

use App\controllers\user\AuthController;
use App\controllers\user\ConnectController;
use App\controllers\user\InterestsController;
use App\controllers\user\MatchesController;
use App\controllers\user\ProfilecreateController;
use App\controllers\user\ProfileviewController;
use App\core\Router;

session_start();
$router = new Router();

$router->get('/register', [AuthController::class, 'registerform']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'loginform']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/user/matches', [MatchesController::class, 'index']);
$router->get('/user/profilecreate', [ProfilecreateController::class, 'index']);
$router->post('/user/profilecreate', [ProfilecreateController::class, 'profile']);
$router->get('/user/profileview', [ProfileviewController::class, 'profileview']);
$router->post('/connect/send', [ConnectController::class, 'send']);
$router->get('/user/interests', [InterestsController::class, 'index']);
$router->dispatch();

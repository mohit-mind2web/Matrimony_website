<?php
require_once __DIR__  . '/../app/config/bootstrap.php';

use App\controllers\user\AuthController;
use App\controllers\user\ConnectController;
use App\controllers\user\HomeController;
use App\controllers\user\InterestsController;
use App\controllers\user\MatchesController;
use App\controllers\user\ProfilecreateController;
use App\controllers\user\ProfileviewController;
use App\controllers\user\SearchController;
use App\controllers\user\ShortlistController;
use App\core\Router;

session_start();
$router = new Router();
$router->get('/',[HomeController::class,'index']);
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
$router->get('/interest/accept', [InterestsController::class, 'accept']);
$router->get('/interest/reject', [InterestsController::class, 'reject']);
$router->get('/user/shortlists',[ShortlistController::class,'index']);
$router->post('/shortlist/toggle',[ShortlistController::class,'toggle']);
$router->post('/user/matches/filter',[MatchesController::class,'filter']);

$router->dispatch();

<?php
require_once __DIR__  . '/../app/config/bootstrap.php';

use App\controllers\admin\DashboardController;
use App\controllers\admin\QueriesController;
use App\controllers\admin\ReportController as AdminReportController;
use App\controllers\user\ReportController;
use App\controllers\admin\UserController;
use App\controllers\user\AuthController;
use App\controllers\user\ConnectController;
use App\controllers\user\ContactController;
use App\controllers\user\HomeController;
use App\controllers\user\InterestsController;
use App\controllers\user\MatchesController;
use App\controllers\user\ProfilecreateController;
use App\controllers\user\ProfileviewController;
use App\controllers\user\ShortlistController;
use App\core\Router;

session_start();
$router = new Router();
//homepage route
$router->get('/',[HomeController::class,'index']);
//register
$router->get('/register', [AuthController::class, 'registerform']);
$router->post('/register', [AuthController::class, 'register']);
//login
$router->get('/login', [AuthController::class, 'loginform']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
//matches page route
$router->get('/user/matches', [MatchesController::class, 'index']);
//profile craete
$router->get('/user/profilecreate', [ProfilecreateController::class, 'index']);
$router->post('/user/profilecreate', [ProfilecreateController::class, 'profile']);
//profile view
$router->get('/user/profileview', [ProfileviewController::class, 'profileview']);
$router->post('/connect/send', [ConnectController::class, 'send']);
// interest rutes
$router->get('/user/interests', [InterestsController::class, 'index']);
$router->get('/interest/accept', [InterestsController::class, 'accept']);
$router->get('/interest/reject', [InterestsController::class, 'reject']);
//shorlist
$router->get('/user/shortlists',[ShortlistController::class,'index']);
$router->post('/shortlist/toggle',[ShortlistController::class,'toggle']);
$router->post('/user/matches/filter',[MatchesController::class,'filter']);
//profileedit page
$router->get('/user/profileedit', [ProfilecreateController::class, 'edit']);
$router->post('/user/profileedit', [ProfilecreateController::class, 'update']);
$router->post('/user/matches/disconnect', [ConnectController::class, 'disconnect']);

//admindashboard
$router->get('/admin/dashboard',[DashboardController::class,'index']);
//usermanage
$router->get('/admin/usermanage',[UserController::class,'index']);
$router->post('/admin/usermanage',[UserController::class,'index']);
$router->post('/admin/user/action',[UserController::class,'toggle']);

$router->post('/user/report',[ReportController::class,'index']);

//manage reports
$router->get('/admin/managereports',[AdminReportController::class,'index']);
$router->post('/admin/managereports',[AdminReportController::class,'index']);
$router->post('/admin/reports/status', [AdminReportController::class, 'updateStatus']);

//contact
$router->get('/user/contactsupport',[ContactController::class,'index']);
$router->post('/user/contactsupport',[ContactController::class,'index']);

//admin manage queries route
$router->get('/admin/managequeries',[QueriesController::class,'index']);
$router->post('/admin/managequeries',[QueriesController::class,'index']);

$router->post('/admin/queries/status',[QueriesController::class,'updatequery']);

$router->dispatch();

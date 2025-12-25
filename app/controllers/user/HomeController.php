<?php
namespace App\controllers\user;

use App\core\Controller;

class HomeController extends Controller{
    public function index(){
        $this->render('home/homepage');

    }
}
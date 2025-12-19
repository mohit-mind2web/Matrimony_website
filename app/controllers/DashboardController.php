<?php
namespace App\controllers;

use App\core\Controller;
use App\helpers\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        Auth::checkLogin();

        $this->view('profile/dashboard');
    }
}

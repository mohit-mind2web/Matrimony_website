<?php
namespace App\controllers;

use App\core\Controller;
use App\helpers\Auth;

class MatchesController extends Controller
{
    public function index()
    {
        Auth::checkLogin();
        $this->view('profile/matches');
    }
}

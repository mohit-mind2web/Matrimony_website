<?php 
namespace App\controllers;

use App\core\Controller;
use App\Helpers\Auth;

class ProfilecreateController extends Controller{
    public function index(){
        $this->view('profile/profilecreation');
    }

}
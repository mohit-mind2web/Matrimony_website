<?php 
namespace App\controllers\user;

use App\core\Controller;

class ContactController extends Controller{
    public function index(){
        $this->view('/profile/contact');
    }
}
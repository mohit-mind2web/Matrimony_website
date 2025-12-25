<?php
namespace App\controllers\user;
use App\core\Controller;
use App\helpers\Auth;
use App\models\ConnectRequest;

class InterestsController extends Controller
{
    public function index()
    {
        Auth::checkLogin();
        $user_id = $_SESSION['user_id'];
        $interestModel = new ConnectRequest();
        $sentinterest = $interestModel->getsentrequest($user_id);
        $receivedinterest = $interestModel->getreceivedrequest($user_id);
        $this->view('profile/interest', [
            'sentinterest' => $sentinterest,
            'receivedinterest' => $receivedinterest
        ]); 
    }

    public function accept(){
         Auth::checkLogin();
         $requestid=$_GET['reqid'];
         $interestModel=new ConnectRequest();
         $interestModel->updateStatus($requestid,1);
         header("Location:/user/interests");
         exit();

    }
    public function reject(){
         Auth::checkLogin();
         $requestid=$_GET['reqid'];
         $interestModel=new ConnectRequest();
         $interestModel->updateStatus($requestid,2);
         header("Location:/user/interests");
         exit();

    }
}

<?php
namespace App\controllers\user;
use App\core\Controller;
use App\helpers\Auth;
use App\helpers\Pagination;
use App\models\ConnectRequest;

class InterestsController extends Controller
{
    public function index()
    {
        Auth::checkLogin();
        $user_id = $_SESSION['user_id'];
        $interestModel = new ConnectRequest();
        $totalsent=$interestModel->countsentinterest($user_id);
        $sentpagination=Pagination::pagination($totalsent,2,'sent_page');
        $sentpagination['tab'] = 'sent';
        $sentinterest = $interestModel->getsentrequest($user_id,$sentpagination['limit'],$sentpagination['offset']);

        $totalreceive=$interestModel->countreceivedinterest($user_id);
        $receivepagination=Pagination::pagination($totalreceive,2,'receive_page');
        $receivepagination['tab'] = 'received';
        $receivedinterest = $interestModel->getreceivedrequest($user_id,$receivepagination['limit'],$receivepagination['offset']);

        $totalaccept=$interestModel->countacceptinterest($user_id);
        $acceptpagination=Pagination::pagination($totalaccept,2,'accept_page');
        $acceptpagination['tab'] = 'accepted';
        $acceptinterest = $interestModel->getacceptrequest($user_id,$acceptpagination['limit'],$acceptpagination['offset']);

        $totaldecline=$interestModel->countdeclineinterest($user_id);
        $declinepagination=Pagination::pagination($totaldecline,2,'decline_page');
        $declinepagination['tab'] = 'declined';
        $declineinterest = $interestModel->getdeclinerequest($user_id,$declinepagination['limit'],$declinepagination['offset']);

        
        $this->view('profile/interest', [
            'sentinterest' => $sentinterest,
            'receivedinterest' => $receivedinterest,
            'sentpagination'=>$sentpagination,
            'receivepagination'=>$receivepagination,
            'acceptinterest'=>$acceptinterest,
            'declineinterest'=>$declineinterest,
            'acceptpagination'=>$acceptpagination,
            'declinepagination'=>$declinepagination

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

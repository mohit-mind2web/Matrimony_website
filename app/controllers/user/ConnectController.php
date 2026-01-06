<?php 
namespace App\controllers\user;
use App\helpers\Auth;
use App\core\Controller;
use App\models\ConnectRequest;
use App\models\UserMatches;

class ConnectController extends Controller{
    //sending connect request function
    public function send(){
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];

    $connectModel = new ConnectRequest();
    if ($connectModel->reconnect($sender_id, $receiver_id)) {
        $status = $connectModel->getRequestStatus($sender_id, $receiver_id);
        echo json_encode(['success' => true, 'status' => $status]);
        exit();
    }
    if ($connectModel->checkExistingRequest($sender_id, $receiver_id)) {
        echo json_encode(['success' => false, 'message' => 'Request already exists']);
        exit();
    }
        $connectModel->sendconnectrequest($sender_id, $receiver_id);
        $status = $connectModel->getRequestStatus($sender_id, $receiver_id);
        echo json_encode(['success' => true, 'status' => $status]);
    
    exit();
}

//get matches profile function
   public function matches() {
    $user_id = $_SESSION['user_id'];
    $userMatchesModel = new UserMatches();
    $profiles = $userMatchesModel->getprofiles($user_id);
    $this->view('profile/matches', [
        'profiles' => $profiles,
        'heights' => $this->constants['heights'] ?? [],
        'religions' => $this->constants['religions'] ?? []
    ]);
}
//disconnect function
 public function disconnect()
{
    Auth::checkLogin();

    $user_id = $_SESSION['user_id'];
    $other_user_id = $_POST['user_id'] ?? null;

    if (!$other_user_id) {
        header("Location: /user/matches");
        exit;
    }

    $interestModel = new UserMatches();
    $interestModel->disconnect($user_id, $other_user_id);

    header("Location: /user/matches");
    exit;
}


}
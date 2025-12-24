<?php 
namespace App\controllers\user;

use App\core\Controller;
use App\models\ConnectRequest;
use App\models\UserMatches;

class ConnectController extends Controller{
    public function send(){
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];

    $connectModel = new ConnectRequest();
    $existrequest = $connectModel->checkExistingRequest($sender_id, $receiver_id);

    if (!$existrequest) {
        $connectModel->sendconnectrequest($sender_id, $receiver_id);
    } 
        $status = $connectModel->getRequestStatus($sender_id, $receiver_id);
        echo json_encode(['success' => true, 'status' => $status]);
    
    exit();
}

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


}
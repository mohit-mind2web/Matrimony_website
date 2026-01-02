<?php 
namespace App\controllers\user;
use App\helpers\Auth;
use App\core\Controller;
use App\helpers\Pagination;
use App\models\ShortlistModel;

class ShortlistController extends Controller{
    public function index(){
       Auth::requireRole([2]);
        $profilecomplete=$_SESSION['profile_complete'];
        $user_id=$_SESSION['user_id'];
        $shortlistModel=new ShortlistModel();
        $total=$shortlistModel->countshortlists($user_id);
        $pagination=Pagination::pagination($total,8);
        $shortlistprofiles=$shortlistModel->getallshortlists($user_id,$pagination['limit'],$pagination['offset']);
        $this->view('profile/shortlist',[
            'shortlistprofiles'=>$shortlistprofiles,
            'profilecomplete'=>$profilecomplete,
            'pagination'=>$pagination
        ]);
    }

    public function toggle(){
        $user_id=$_SESSION['user_id'];
        $shortlist_id=$_POST['shortlist_userid'];
        $shortlistModel=new ShortlistModel();
       if($shortlistModel->shortlistexists($user_id,$shortlist_id)){
         $shortlistModel->shortlistremove($user_id,$shortlist_id);
         $status='removed';
       }
       else{
        $shortlistModel->shortlistadd($user_id,$shortlist_id);
        $status='added';
       }
       echo json_encode(['status'=>$status]);
       exit;
       
    }
}
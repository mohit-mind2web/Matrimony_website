<?php 
namespace App\controllers\admin;

use App\core\Controller;
use App\helpers\Pagination;
use App\models\admin\UserModel;

class UserController extends Controller{
    public function index(){
        $userModel=new UserModel();
        $total=$userModel->getcountusers();
        $pagination=Pagination::pagination($total,5);
        $userdetails=$userModel->getallusers($pagination['limit'],$pagination['offset']);
        $this->view('/admin/manageusers',[
            'userdetails'=>$userdetails,
            'pagination'=>$pagination
        ]);
    }

    public function toggle(){
        $user_id=$_POST['user_id'];
         $userModel=new UserModel();
         $userModel->statusupdate($user_id);
         header("Location:/admin/usermanage");
         exit(); 
    }
}
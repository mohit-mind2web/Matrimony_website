<?php 
namespace App\controllers\user;
use App\helpers\Auth;
use App\core\Controller;
use App\models\Profile;
class ProfileviewController extends Controller{
    public function profileview(){
         Auth::checkLogin();
          
    $user_id = $_GET['id'] ?? null; 
           $constants = require APPROOT . '/config/constants.php';
$genders=$constants['genders'] ?? [];
$heights = $constants['heights'] ?? [];
$religions = $constants['religions'] ?? [];
$professions=$constants['professions'] ??[];
$educations=$constants['educations']??[];

     $profileModel = new Profile();
        $profileview = $profileModel->getprofilebyid($user_id);
        if (!$profileview) {
            die('Profile not found');
        }
        $this->view('profile/profileview',[
              'profileview' => $profileview,
              'gender'=>$genders,
              'height'=>$heights,
              'religions'=>$religions,
              'profession'=>$professions,
              'education'=>$educations
            
        ]);
    }
}
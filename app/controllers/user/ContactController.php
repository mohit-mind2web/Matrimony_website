<?php 
namespace App\controllers\user;

use App\core\Controller;
use App\models\ContactModel;
use App\models\UserModel;

class ContactController extends Controller{
    public function index(){
        $user_id=$_SESSION['user_id'];
        $userModel=new UserModel();
        $userdetails=$userModel->getusersdata($user_id);
        $message='';
        $errors=[];
       if (isset($_POST['submit'])) {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);

            if (empty($name) || !preg_match("/^[A-Za-z ]{3,50}$/", $name)) {
                $errors[] = "Name must be 3–50 characters and contain only letters & spaces.";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Please enter a valid email address.";
            }
            if (empty($subject) || strlen($subject) < 3) {
                $errors[] = "Subject must be at least 3 characters.";
            }
            if (empty($message) || strlen($message) < 10) {
                $errors[] = "Message must be at least 10 characters.";
            }
            if (empty($errors)) {
                $contactModel = new ContactModel();
                $data = [
                    'fullname' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                ];
                if ($contactModel->sendquery($user_id, $data)) {
                    $message = "Message Sent Successfully";
                } else {
                    $errors[] = "Something Wrong While sending query";
                }
            }

        }

        $this->view('/profile/contact',[
            'message'=>$message,
            'errors'=>$errors,
            'userdetails'=>$userdetails

        ]);
    }
}
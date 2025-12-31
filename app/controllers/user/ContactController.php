<?php

namespace App\controllers\user;

use App\core\Controller;
use App\models\ContactModel;
use App\models\UserModel;

class ContactController extends Controller
{
    public function index()
    {
        $user_id = $_SESSION['user_id'];
        $userModel = new UserModel();
        $userdetails = $userModel->getusersdata($user_id);
        $success = '';
        $errors = [];
        if (isset($_POST['submit'])) {
            $name = $userdetails['fullname'];
            $email = $userdetails['email'];
               $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);
            
            if ((!isset($_POST['name']) || $_POST['name'] !== $name) || 
                (!isset($_POST['email']) || $_POST['email'] !== $email)) {
                $errors[] = "Security Violation: Name or Email does not match your profile.";
            }
            if (empty($subject) || strlen($subject) < 3 || !preg_match("/^[A-Za-z0-9 ]+$/", $subject)) {
                $errors[] = "Subject must be at least 3 characters long and only contain letters, numbers, and spaces.";
            }
            if (empty($message) || strlen($message) < 10) {
                $errors[] = "Message must be at least 10 characters long.";
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
                    $success = "Message Sent Successfully";
                } else {
                    $errors[] = "Something Wrong While sending query";
                }
            }
        }

        $this->view('/profile/contact', [
            'success' => $success,
            'errors' => $errors,
            'userdetails' => $userdetails

        ]);
    }
}

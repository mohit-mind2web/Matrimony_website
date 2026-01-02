<?php

namespace App\controllers\user;
use App\helpers\Mailer;
use App\core\Controller;
use App\models\UserModel;
use App\helpers\Auth;
use App\helpers\ActivityLogger;

class AuthController extends Controller
{
    //function to render register from
    public function registerform()
    {
        $this->render('auth/register');
    }
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location:/register');
            exit();
        }
        $userModel = new UserModel();
        $profile_for = (int)$_POST['profile_for'];
        $fullname = htmlspecialchars($_POST['fullname']);
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $errors = [];
        $success='';

        if (!in_array($profile_for, [1, 2, 3, 4])) {
            $errors[] = 'Please select a valid profile type';
        }
        if ($fullname === '' || !preg_match("/^[A-Za-z\s]{3,50}$/", $fullname)) {
            $errors[] = 'Full Name must be 3-50 letters only';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email';
        }

        if ($userModel->emailExists($email)) {
            $errors[] = 'Email already registered';
        }

        if (strlen($password) < 6 || strlen($password) > 255) {
            $errors[] = 'Password must be betwwen 6 to 255 characters';
        }

        $data = [
            'profile_for' => $profile_for,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password,
            'role_id' => 2
        ];
        if (!empty($errors)) {
            $this->view('auth/register', ['errors' => $errors]);
            return;
        }

        if ($userModel->create($data)) {
            // Send welcome email
            Mailer::sendWelcomeEmail($email, $fullname);
            // Log registration
             $user = $userModel->getuser($email); // Fetch newly created user to get ID
             if($user){
                 ActivityLogger::log('REGISTER', "User registered with email: $email", $user['id'], 2);
             } else {
                 // Fallback if fetch fails, though unlikely
                  ActivityLogger::log('REGISTER', "User registered with email: $email (ID fetch failed)");
             }
            $success = 'Registration successful! <a href="/login">Login Now</a>.';
             $this->view('auth/register', ['success' => $success]);
              return;
        }

        $this->view(
            'auth/register',
            [
                'errors' => ['Registration failed. Please try again.'],
                'success'=>$success
            ]
        );
    }

    //functioon to render login form
    public function loginForm()
    {
        Auth::redirectIfLoggedIn();
        $this->render('auth/login');
    }
    public function login()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location:/login');
            exit();
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        $loginModel = new UserModel();
        $user = $loginModel->getuser($email);
        if (!$user) {
            $errors[] = "Email Not found";
        } elseif($user['status']==0){
           $errors[] = "Your account has been blocked by admin. Please contact 
                        <a href=\"mailto:admin@soulmates.com\">admin@soulmates.com</a>.";
        }
        elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Password Incorrect";
        }
        if (!empty($errors)) {
            $this->view('auth/login', ['errors' => $errors]);
            return;
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['profile_complete'] = $user['profile_complete'];
        
        // Log Login
        ActivityLogger::log('LOGIN', "User logged in: " . $user['email'], $user['id'], $user['role_id']);

        setcookie('user_id', $_SESSION['user_id'], time() + (30 * 24 * 60 * 60), "/"); //30 days

        if ($_SESSION['role_id'] == 1) {
            header('Location:/admin/dashboard');
            exit();
        }
        if ($_SESSION['role_id'] == 2)
            if ($_SESSION['profile_complete'] == 1) {
                header('Location: user/matches');
                exit();
            } else {
                header('Location: user/profilecreate');
                exit();
            }
    }
    public function logout()
    {
        ActivityLogger::log('LOGOUT', "User logged out");
        Auth::logout();
    }
}

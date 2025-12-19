<?php

namespace App\controllers;

use App\core\Controller;
use App\models\UserModel;
use App\helpers\Auth;

class AuthController extends Controller
{
    //function to render register from
    public function registerform()
    {
        $this->view('auth/register');
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

        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
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
            header('Location: /login');
            exit();
        }

        $this->view(
            'auth/register',
            [
                'errors' => ['Registration failed. Please try again.']
            ]
        );
    }

    //functioon to render login form
    public function loginForm()
    {
        $this->view('auth/login');
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
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Password Incorrect";
        }
        if (!empty($errors)) {
            $this->view('auth/login', ['errors' => $errors]);
            return;
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['fullname'] = $user['fullname'];

        if (!empty($user['profile_complete']) && $user['profile_complete'] == 1) {
            header('Location: user/dashboard');
            exit();
        } else {
            header('Location: user/profilecreate');
            exit();
        }
    }
    public function logout()
    {
        Auth::logout();
    }
}

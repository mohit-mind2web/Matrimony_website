<?php
namespace App\Helpers;

class Auth
{
    private static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function checkLogin(): void
    {
        
         self::initSession();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
    }

    public static function requireRole(array $roles): void
    {
        self::checkLogin();

        if (!in_array($_SESSION['role_id'], $roles)) {
            header("HTTP/1.0 403 Forbidden");
            require __DIR__ . '/../views/layouts/access.php';
            exit();
        }
    }
    public static function redirectIfLoggedIn(): void
    {
         self::initSession();
        if (isset($_SESSION['role_id'])) {
            $role = $_SESSION['role_id'];
            if ($role == 'admin' || $role == 1) {
                header("Location: /admin/dashboard");
            } 
            else{
                   header("Location: /user/matches");
            }
            exit();
        }
    }
    public static function logout(): void
    {
       self::initSession();
        session_destroy();
        header("Location: /");
        exit();
    }
}

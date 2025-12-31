<?php

namespace App\controllers\admin;
use App\helpers\Auth;
use App\core\Controller;
use App\helpers\Pagination;
use App\models\admin\UserModel;

class UserController extends Controller
{
    public function index()
    {
        Auth::requireRole([1]);
        if (isset($_POST['reset_filters']) && $_POST['reset_filters'] == 1) {
            unset($_SESSION['user_filters']);
            header("Location: /admin/usermanage");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['user_filters'] = [
                'name' => trim($_POST['name'] ?? ''),
                'profilestatus' => $_POST['profilestatus'] ?? '',
                'userstatus' => $_POST['userstatus'] ?? '',
            ];
        }

        $filters = $_SESSION['user_filters'] ?? [
            'name' => '',
            'profilestatus' => '',
            'userstatus' => '',
        ];
        $userModel = new UserModel();
        $total = $userModel->getcountusers($filters);
        $pagination = Pagination::pagination($total, 10);
        $userdetails = $userModel->getallusers($filters, $pagination['limit'], $pagination['offset']);
        $this->view('/admin/manageusers', [
            'userdetails' => $userdetails,
            'pagination' => $pagination,
            'filters' => $filters
        ]);
    }

    public function toggle()
    {
        $user_id = $_POST['user_id'];
        $userModel = new UserModel();
        $userModel->statusupdate($user_id);
        header("Location:/admin/usermanage");
        exit();
    }
}

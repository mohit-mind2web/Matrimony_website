<?php

namespace App\controllers\admin;
use App\helpers\Auth;
use App\core\Controller;
use App\helpers\Pagination;
use App\models\admin\UserModel;

class UserController extends Controller
{
    //user manage page
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

        if (isset($_POST['export']) && $_POST['export'] == 1) {
            $userdetails = $userModel->getallusers($filters, 100000, 0);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="users.csv"');
            $output = fopen('php://output', 'w');
            fputcsv($output, ['User Id', 'Full Name', 'Email', 'Profile Status', 'Status', 'Joined At']);
            foreach ($userdetails as $user) {
                fputcsv($output, [
                    $user['id'],
                    $user['fullname'],
                    $user['email'],
                    $user['profile_complete'] ? 'Completed' : 'Incomplete',
                    $user['status'] == 1 ? 'Active' : 'Blocked',
                    date('d M Y', strtotime($user['created_at']))
                ]);
            }
            fclose($output);
            exit;
        }

        $total = $userModel->getcountusers($filters);
        $pagination = Pagination::pagination($total, 10);
        $userdetails = $userModel->getallusers($filters, $pagination['limit'], $pagination['offset']);
        $this->view('/admin/manageusers', [
            'userdetails' => $userdetails,
            'pagination' => $pagination,
            'filters' => $filters
        ]);
    }

    //update status 
    public function toggle()
    {
        $user_id = $_POST['user_id'];
        $userModel = new UserModel();
        $userModel->statusupdate($user_id);
        header("Location:/admin/usermanage");
        exit();
    }
}

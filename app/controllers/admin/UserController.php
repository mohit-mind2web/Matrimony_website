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
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (isset($_POST['reset_filters']) && $_POST['reset_filters'] == 1) {
            unset($_SESSION['user_filters']);
            if (!$isAjax) {
                header("Location: /admin/usermanage");
                exit;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['export'])) {
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
            if (ob_get_level()) ob_end_clean();
            
            $previous_error_reporting = ini_get('display_errors');
            ini_set('display_errors', 0);

            $userdetails = $userModel->getallusers($filters, 100000, 0);
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="users.csv"');
            
            $output = fopen('php://output', 'w');
            
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($output, ['Id', 'Full Name', 'Email', 'Profile Status', 'Status', 'Joined At'], ",", "\"", "\\");
            foreach ($userdetails as $key => $user) {
                fputcsv($output, [
                   $key+1,
                    $user['fullname'],
                    $user['email'],
                    $user['profile_complete'] ? 'Completed' : 'Incomplete',
                    $user['status'] == 1 ? 'Active' : 'Blocked',
                    date('d M Y', strtotime($user['created_at']))
                ], ",", "\"", "\\");
            }
            fclose($output);
            ini_set('display_errors', $previous_error_reporting);
            exit;
        }

        $total = $userModel->getcountusers($filters);
        $pagination = Pagination::pagination($total, 10);
        $userdetails = $userModel->getallusers($filters, $pagination['limit'], $pagination['offset']);

        if ($isAjax) {
             $this->render('/admin/partials/users_table', [
                'userdetails' => $userdetails,
                'pagination' => $pagination,
                'filters' => $filters
            ]);
        } else {
            $this->view('/admin/manageusers', [
                'userdetails' => $userdetails,
                'pagination' => $pagination,
                'filters' => $filters
            ]);
        }
    }

    public function toggle()
    {
        $user_id = $_POST['user_id'];
        $userModel = new UserModel();
        $userModel->statusupdate($user_id);
        
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit;
        }

        header("Location:/admin/usermanage");
        exit();
    }
}

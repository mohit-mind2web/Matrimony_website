<?php
namespace App\controllers\admin;
use App\core\Controller;
use App\helpers\Auth;
use App\helpers\Pagination;
use App\models\admin\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        Auth::requireRole([1]);
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (isset($_POST['reset_filters']) && $_POST['reset_filters'] == 1) {
            unset($_SESSION['activity_filters']);
            if (!$isAjax) {
                header("Location: /admin/activity-logs");
                exit;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['activity_filters'] = [
                'email' => trim($_POST['email'] ?? ''),
                'activity_type' => $_POST['activity_type'] ?? '',
                'date_range' => $_POST['date_range'] ?? '',
            ];
        }

        $filters = $_SESSION['activity_filters'] ?? [
            'email' => '',
            'activity_type' => '',
            'date_range' => '',
        ];
        if (!empty($filters['date_range'])) {
            $dates = explode(' to ', $filters['date_range']);
            $filters['date_from'] = $dates[0] ?? '';
            $filters['date_to'] = $dates[1] ?? $dates[0]; 
        }

        $activityModel=new ActivityLog();
        $total=$activityModel->countLogs($filters);
        $pagination = Pagination::pagination($total, 8);

        $logs = $activityModel->getLogs(
            $pagination['limit'],
            $pagination['offset'],
            $filters
        );

        if ($isAjax) {
            $this->render('admin/partials/activity_logs_table', [
                'logs' => $logs,
                'pagination' => $pagination,
                'filters' => $filters
            ]);
        } else {
            $this->view('admin/activity_logs', [
                'logs' => $logs,
                'pagination' => $pagination,
                'filters' => $filters
            ]);
        }
    }
}

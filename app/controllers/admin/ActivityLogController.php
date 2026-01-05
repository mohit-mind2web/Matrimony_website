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
        $activityModel=new ActivityLog();
$total=$activityModel->countLogs();
        $pagination = Pagination::pagination($total, 5);

        $logs = $activityModel->getLogs(
            $pagination['limit'],
            $pagination['offset']
        );

        $this->view('admin/activity_logs', [
            'logs' => $logs,
            'pagination' => $pagination
        ]);
    }
}

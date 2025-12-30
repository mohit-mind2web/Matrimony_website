<?php

namespace App\controllers\admin;
use App\helpers\Auth;
use App\core\Controller;
use App\helpers\Pagination;
use App\models\admin\ReportModel;

class ReportController extends Controller
{
    public function index()
    {
        Auth::requireRole([1]);
        if (isset($_POST['reset_filters']) && $_POST['reset_filters'] == 1) {
            unset($_SESSION['report_filters']);
            header("Location: /admin/managereports");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['report_filters'] = [
                'status' => $_POST['status'] ?? '',
                'date_range' => $_POST['date_range'] ?? '',
            ];
        }

        $filters = $_SESSION['report_filters'] ?? [
            'status' => '',
            'date_range' => '',
        ];
        $reportModel = new ReportModel();
        $total = $reportModel->getcountreports($filters);
        $pagination = Pagination::pagination($total, 5);
        $reportdetails = $reportModel->getallreports($filters, $pagination['limit'], $pagination['offset']);
        $this->view('/admin/managereports', [
            'reportdetails' => $reportdetails,
            'pagination' => $pagination,
            'filters' => $filters
        ]);
    }
    public function updateStatus()
    {
        $reportId = $_POST['report_id'];
        $status   = $_POST['status'];
        $reportModel = new ReportModel();
        $reportModel->updateStatus($reportId, $status);
        $_SESSION['success'] = 'Report status updated successfully.';
        header("Location: /admin/managereports");
        exit;
    }
}

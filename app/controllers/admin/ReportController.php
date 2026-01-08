<?php

namespace App\controllers\admin;
use App\helpers\Auth;
use App\core\Controller;
use App\helpers\Pagination;
use App\models\admin\ReportModel;

class ReportController extends Controller
{
    //report manage page
    public function index()
    {
        Auth::requireRole([1]);
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (isset($_POST['reset_filters']) && $_POST['reset_filters'] == 1) {
            unset($_SESSION['report_filters']);
            if (!$isAjax) {
                header("Location: /admin/managereports");
                exit;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        if ($isAjax) {
             $this->render('/admin/partials/reports_table', [
                'reportdetails' => $reportdetails,
                'pagination' => $pagination,
                'filters' => $filters
            ]);
        } else {
            $this->view('/admin/managereports', [
                'reportdetails' => $reportdetails,
                'pagination' => $pagination,
                'filters' => $filters
            ]);
        }
    }

    //update report status
    public function updateStatus()
    {
        $reportId = $_POST['report_id'];
        $status   = $_POST['status'];
        $reportModel = new ReportModel();
        $reportModel->updateStatus($reportId, $status);
        
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit;
        }

        $_SESSION['success'] = 'Report status updated successfully.';
        header("Location: /admin/managereports");
        exit;
    }
}

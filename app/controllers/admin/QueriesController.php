<?php

namespace App\controllers\admin;
use App\helpers\Auth;
use App\core\Controller;
use App\helpers\Pagination;
use App\models\admin\QueriesModel;

class QueriesController extends Controller
{
    //queries manage page
    public function index()
    {
        Auth::requireRole([1]);
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (isset($_POST['reset_filters']) && $_POST['reset_filters'] == 1) {
            unset($_SESSION['query_filters']);
            if (!$isAjax) {
                header("Location: /admin/managequeries");
                exit;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['query_filters'] = [
                'name' => trim($_POST['name'] ?? ''),
                'status' => $_POST['status'] ?? '',
                'date_range' => $_POST['date_range'] ?? '',
            ];
        }
        $filters = $_SESSION['query_filters'] ?? [
            'name' => '',
            'status' => '',
            'date_range' => '',
        ];
        $queriesModel = new QueriesModel();
        $total = $queriesModel->countqueries($filters);
        $pagination = Pagination::pagination($total, 5);
        $queriesdetails = $queriesModel->getqueries($filters, $pagination['limit'], $pagination['offset']);

        if ($isAjax) {
             $this->render('/admin/partials/queries_table', [
                'queriesdetails' => $queriesdetails,
                'pagination' => $pagination,
                'filters' => $filters
            ]);
        } else {
            $this->view('admin/managequeries', [
                'queriesdetails' => $queriesdetails,
                'pagination' => $pagination,
                'filters' => $filters
            ]);
        }
    }

    //update query status
    public function updatequery()
    {
        $queryid = (int)$_POST['query_id'];
        $status = (int) $_POST['status'];
        $queriesModel = new QueriesModel();
        $queriesModel->updatequerystatus($queryid, $status);
        
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit;
        }

        $_SESSION['message'] = 'Query status updated successfully.';
        header("Location:/admin/managequeries");
        exit();
    }
}

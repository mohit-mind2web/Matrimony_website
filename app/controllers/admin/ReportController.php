<?php 
namespace App\controllers\admin;

use App\core\Controller;
use App\helpers\Pagination;
use App\models\admin\ReportModel;

class ReportController extends Controller{
    public function index(){
        $reportModel=new ReportModel();
        $total=$reportModel->getcountreports();
        $pagination=Pagination::pagination($total,5);
        $reportdetails=$reportModel->getallreports($pagination['limit'],$pagination['offset']);
        $this->view('/admin/managereports',[
            'reportdetails'=>$reportdetails,
            'pagination'=>$pagination
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
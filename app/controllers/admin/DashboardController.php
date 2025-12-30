<?php
namespace App\controllers\admin;
use App\helpers\Auth;
use App\core\Controller;
use App\models\admin\DashboardModel;

class DashboardController extends Controller{
    public function index(){
        Auth::requireRole([1]);
        $dashboardModel =new DashboardModel();
        $totalcounts=$dashboardModel->gettotalusers();
        $totalprofiles=$dashboardModel->gettotalprofiles();
        $this->view('admin/dashboard',[
            'totalcounts'=>$totalcounts,
            'totalprofiles'=>$totalprofiles,
        ]);
    }
}
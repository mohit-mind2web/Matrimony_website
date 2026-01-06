<?php
namespace App\controllers\admin;
use App\helpers\Auth;
use App\core\Controller;
use App\models\admin\DashboardModel;
use App\models\ContactModel;
class DashboardController extends Controller{

    //dashboard page
    public function index(){
        Auth::requireRole([1]);
        $dashboardModel =new DashboardModel();
        $totalcounts=$dashboardModel->gettotalusers();
        $totalprofiles=$dashboardModel->gettotalprofiles();
        $contactModel = new ContactModel();
        $recentQueries = $contactModel->getRecentQueries(5); 

        $this->view('admin/dashboard',[
            'totalcounts'=>$totalcounts,
            'totalprofiles'=>$totalprofiles,
            'recentQueries' => $recentQueries
        ]);
    }
}
<?php 
namespace App\controllers\user;
use App\helpers\Auth;
use App\core\Controller;
use App\models\ReportModel;

class ReportController extends Controller{
    public function index(){
        Auth::requireRole([2]);
        $reporterId = $_SESSION['user_id'];
        $reportedUserId=$_POST['reported_id'];
         $reason = trim($_POST['reason'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($reporterId == $reportedUserId) {
            $_SESSION['error'] = 'You cannot report your own profile.';
            header("Location: /user/profileview/$reportedUserId");
            exit;
        }
        if ($reason === '') {
            $_SESSION['error'] = 'Please select a reason.';
            header("Location: /user/profileview?id=$reportedUserId");
            exit;
        }
        if (strlen($description) > 255) {
            $_SESSION['error'] = 'Description must be under 255 characters.';
            header("Location: /user/profileview?id=$reportedUserId");
            exit;
        }
        $reportModel = new ReportModel();
        if ($reportModel->alreadyReported($reporterId, $reportedUserId)) {
            $_SESSION['error'] = 'You have already reported this profile.';
            header("Location: /user/profileview?id=$reportedUserId");
            exit;
        }
        $reportModel->addreport($reporterId, $reportedUserId, $reason, $description);
        $_SESSION['success'] = 'Profile reported successfully.';
        header("Location: /user/profileview?id=$reportedUserId");
        exit;
    }


    
        
    }
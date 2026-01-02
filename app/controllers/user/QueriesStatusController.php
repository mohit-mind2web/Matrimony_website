<?php 
namespace App\controllers\user;

use App\core\Controller;

use App\models\ContactModel;
use App\helpers\Pagination;

class QueriesStatusController extends Controller{
     public function index()
    {
        // verify login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $user_id = $_SESSION['user_id'];
        $queries = new ContactModel();
        
        $limit = 5;
        $total = $queries->countqueries($user_id);
        $pagination = Pagination::pagination($total, $limit);
        
        $queriesdetails = $queries->getUserQueries($user_id, $limit, $pagination['offset']);
        
        $this->view('profile/queriesstatus', [
            'queriesdetails' => $queriesdetails,
            'pagination' => $pagination,
            'filters' => [] 
        ]);
    }
}
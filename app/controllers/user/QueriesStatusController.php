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
        
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $_SESSION['user_queries_filters'] = [
                 'status' => $_POST['status'] ?? ''
             ];
        }

        $filters = $_SESSION['user_queries_filters'] ?? ['status' => ''];

        $queries = new ContactModel();
        
        $limit = 5;
        $total = $queries->countqueries($user_id, $filters);
        $pagination = Pagination::pagination($total, $limit);
        
        $queriesdetails = $queries->getUserQueries($user_id, $limit, $pagination['offset'], $filters);
        
        if ($isAjax) {
             $this->render('profile/partials/queries_status_table', [
                'queriesdetails' => $queriesdetails,
                'pagination' => $pagination
            ]);
        } else {
            $this->view('profile/queriesstatus', [
                'queriesdetails' => $queriesdetails,
                'pagination' => $pagination,
                'filters' => $filters 
            ]);
        }
    }
}
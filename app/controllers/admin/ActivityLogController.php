<?php

namespace App\controllers\admin;

use App\core\Controller;
use App\core\Database;
use App\helpers\Auth;

class ActivityLogController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        Auth::requireRole([1]); // Ensure only admin can access

        // Pagination setup
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT al.*, u.email 
                FROM activity_logs al 
                LEFT JOIN users u ON al.user_id = u.id 
                ORDER BY al.created_at DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $logs = $result->fetch_all(MYSQLI_ASSOC);

        // Get total count for pagination
        $countSql = "SELECT COUNT(*) as total FROM activity_logs";
        $countResult = $this->db->query($countSql);
        $totalRows = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRows / $limit);

        $this->render('admin/activity_logs', [
            'logs' => $logs,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }
}

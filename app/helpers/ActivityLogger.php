<?php
namespace App\helpers;
use App\core\Database;
use App\core\Model;
use App\models\admin\ActivityLog;


class ActivityLogger extends Model {
    
    public static function log($activityType, $description, $userId = null, $userRole = null) {
        
        // Attempt to get user info from session if not provided
        if ($userId === null && isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }
        
        if ($userRole === null && isset($_SESSION['role_id'])) {
            $userRole = $_SESSION['role_id'];
        }

        // Get IP and User Agent
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
$log = new ActivityLog();
        $log->create(
            $userId,
            $userRole,
            $activityType,
            $description,
            $ipAddress,
            $userAgent
        );
    }
}

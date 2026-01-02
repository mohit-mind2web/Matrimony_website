<?php

namespace App\helpers;

use App\core\Database;

class ActivityLogger {
    
    public static function log($activityType, $description, $userId = null, $userRole = null) {
        $conn = Database::connect();
        
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

        $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, user_role, activity_type, description, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("isssss", $userId, $userRole, $activityType, $description, $ipAddress, $userAgent);
            $stmt->execute();
            $stmt->close();
        }
    }
}

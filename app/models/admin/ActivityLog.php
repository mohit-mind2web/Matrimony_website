<?php
namespace App\models\admin;

use App\core\Model;

class ActivityLog extends Model
{
    public function countLogs($filters = [])
    {
        $sql = "SELECT COUNT(*) AS total FROM activity_logs al 
                LEFT JOIN users u ON al.user_id = u.id 
                WHERE 1=1";
        
        $params = [];
        $types = "";

        if (!empty($filters['email'])) {
            $sql .= " AND u.email LIKE ?";
            $params[] = "%" . $filters['email'] . "%";
            $types .= "s";
        }
        if (!empty($filters['role'])) {
            $sql .= " AND al.user_role = ?";
            $params[] = $filters['role'];
            $types .= "s";
        }
        if (!empty($filters['activity_type'])) {
            $sql .= " AND al.activity_type = ?";
            $params[] = $filters['activity_type'];
            $types .= "s";
        }
        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(al.created_at) >= ?";
            $params[] = $filters['date_from'];
            $types .= "s";
        }
        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(al.created_at) <= ?";
            $params[] = $filters['date_to'];
            $types .= "s";
        }

        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getLogs($limit, $offset, $filters = [])
    {
        $sql = "SELECT al.*, u.email
                FROM activity_logs al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE 1=1";
        
        $params = [];
        $types = "";

        if (!empty($filters['email'])) {
            $sql .= " AND u.email LIKE ?";
            $params[] = "%" . $filters['email'] . "%";
            $types .= "s";
        }
        if (!empty($filters['role'])) {
            $sql .= " AND al.user_role = ?";
            $params[] = $filters['role'];
            $types .= "s";
        }
        if (!empty($filters['activity_type'])) {
            $sql .= " AND al.activity_type = ?";
            $params[] = $filters['activity_type'];
            $types .= "s";
        }
        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(al.created_at) >= ?";
            $params[] = $filters['date_from'];
            $types .= "s";
        }
        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(al.created_at) <= ?";
            $params[] = $filters['date_to'];
            $types .= "s";
        }

        $sql .= " ORDER BY al.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create($userId, $userRole, $activityType, $description, $ipAddress, $userAgent)
    {
        $sql = "INSERT INTO activity_logs
                (user_id, user_role, activity_type, description, ip_address, user_agent)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isssss",
            $userId,
            $userRole,
            $activityType,
            $description,
            $ipAddress,
            $userAgent
        );
        $stmt->execute();
        $stmt->close();
    }
}

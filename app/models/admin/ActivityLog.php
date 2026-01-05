<?php
namespace App\models\admin;

use App\core\Model;

class ActivityLog extends Model
{
    public function countLogs()
    {
        $sql = "SELECT COUNT(*) AS total FROM activity_logs WHERE 1=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getLogs( $limit, $offset)
    {
        $sql = "SELECT al.*, u.email
                FROM activity_logs al
                LEFT JOIN users u ON al.user_id = u.id
                ORDER BY al.created_at DESC
                LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
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

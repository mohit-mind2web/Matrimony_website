<?php

namespace App\models\admin;

use App\core\Model;

class UserModel extends Model
{
    public function getallusers($filters, $limit, $offset = 0)
    {
        $sql = "SELECT * from users WHERE role_id=2 ";
        $params = [];
        $types = "";

        if ($filters['name'] !== '') {
            $sql .= " AND fullname LIKE ?";
            $params[] = "%" . $filters['name'] . "%";
            $types .= "s";
        }

        if ($filters['profilestatus'] !== '') {
            $sql .= " AND profile_complete = ?";
            $params[] = (int)$filters['profilestatus'];
            $types .= "i";
        }

        if ($filters['userstatus'] !== '') {
            $sql .= " AND status = ?";
            $params[] = (int)$filters['userstatus'];
            $types .= "i";
        }

        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function statusupdate($user_id)
    {
        $sql = "UPDATE users SET status=IF(status=1,0,1) WHERE id=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
    public function getcountusers($filters)
    {
        $sql = "SELECT COUNT(*) AS total FROM users WHERE role_id=2";
        $params = [];
        $types = "";

        if ($filters['name'] !== '') {
            $sql .= " AND (fullname LIKE ? )";
            $params[] = "%" . $filters['name'] . "%";
            $types .= "s";
        }

        if ($filters['profilestatus'] !== '') {
            $sql .= " AND profile_complete = ?";
            $params[] = (int)$filters['profilestatus'];
            $types .= "i";
        }

        if ($filters['userstatus'] !== '') {
            $sql .= " AND status = ?";
            $params[] = (int)$filters['userstatus'];
            $types .= "i";
        }

        $stmt = $this->conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }
}

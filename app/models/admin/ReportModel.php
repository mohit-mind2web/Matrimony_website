<?php

namespace App\models\admin;

use App\core\Model;

class ReportModel extends Model
{
    public function getallreports($filters, $limit, $offset = 0)
    {
        $sql = "SELECT r.*, u1.fullname AS reporter_name,u2.fullname AS reported_name
            FROM reports r
            JOIN users u1 ON r.reporter_id = u1.id
            JOIN users u2 ON r.reported_id = u2.id";
        $params = [];
        $types = "";
        $conditions = [];
        if ($filters['status'] !== '') {
            $conditions[] = "r.status= ?";
            $params[] = (int) $filters['status'];
            $types .= "i";
        }
        if (!empty($filters['date_range'])) {
            $dates = explode("to", $filters['date_range']);
            if (count($dates) == 2) {
                $conditions[] = "DATE(r.created_at) BETWEEN ? AND ?";
                $params[] = trim($dates[0]);
                $params[] = trim($dates[1]);
                $types .= "ss";
            }
        }
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY r.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getcountreports($filters)
    {
        $sql = "SELECT COUNT(*) AS total FROM reports r";
        $params = [];
        $types = "";
        $conditions = [];
        if ($filters['status'] !== '') {
            $conditions[] = "r.status= ?";
            $params[] = (int) $filters['status'];
            $types .= "i";
        }
        if (!empty($filters['date_range'])) {
            $dates = explode("to", $filters['date_range']);
            if (count($dates) == 2) {
                $conditions[] = "DATE(r.created_at) BETWEEN ? AND ?";
                $params[] = trim($dates[0]);
                $params[] = trim($dates[1]);
                $types .= "ss";
            }
        }
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $this->conn->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }


    public function updateStatus($reportId, $status)
    {
        $sql = "UPDATE reports SET status=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $reportId);
        return $stmt->execute();
    }
}

<?php

namespace App\models\admin;

use App\core\Model;

class QueriesModel extends Model
{
    public function getqueries($filters, $limit = 5, $offset = 0)
    {
        $sql = "SELECT * FROM queries";
        $params = [];
        $types = "";
        $conditions = [];

        if (!empty($filters['name'])) {
            $conditions[] = "(fullname LIKE ? OR email LIKE ?)";
            $params[] = "%" . $filters['name'] . "%";
            $params[] = "%" . $filters['name'] . "%";
            $types .= "ss";
        }
        if ($filters['status'] !== '') {
            $conditions[] = "status = ?";
            $params[] = (int)$filters['status'];
            $types .= "i";
        }
        if (!empty($filters['date_range'])) {
            $dates = explode(" to ", $filters['date_range']);
            if (count($dates) == 2) {
                $conditions[] = "DATE(created_at) BETWEEN ? AND ?";
                $params[] = $dates[0];
                $params[] = $dates[1];
                $types .= "ss";
            }
        }
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
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

    public function countqueries($filters)
    {
        $sql = "SELECT COUNT(*) AS total FROM queries";
        $params = [];
        $types = "";
        $conditions = [];

        if (!empty($filters['name'])) {
            $conditions[] = "(fullname LIKE ? OR email LIKE ?)";
            $params[] = "%" . $filters['name'] . "%";
            $params[] = "%" . $filters['name'] . "%";
            $types .= "ss";
        }
        if ($filters['status'] !== '') {
            $conditions[] = "status = ?";
            $params[] = (int)$filters['status'];
            $types .= "i";
        }
        if (!empty($filters['date_range'])) {
            $dates = explode(" to ", $filters['date_range']);
            if (count($dates) == 2) {
                $conditions[] = "DATE(created_at) BETWEEN ? AND ?";
                $params[] = $dates[0];
                $params[] = $dates[1];
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

    public function updatequerystatus($queryid, $status)
    {
        $sql = "UPDATE queries SET status=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $queryid);
        return $stmt->execute();
    }
}

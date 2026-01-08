<?php 
namespace App\models;

use App\core\Model;

class ContactModel extends Model{
    public function sendquery($user_id,Array $data){
        $sql="INSERT INTO queries(user_id,fullname,email,subject,message)
        VALUES(?,?,?,?,?)";
        $stmt=$this->conn->prepare($sql);
        $stmt->bind_param('issss',
            $user_id,
            $data['fullname'],
            $data['email'],
            $data['subject'],
            $data['message']
        );
        return $stmt->execute();
        
    }

    public function getRecentQueries($limit = 5) {
        $sql = "SELECT * FROM queries ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserQueries($user_id, $limit = 5, $offset = 0, $filters = []) {
        $sql = "SELECT * FROM queries WHERE user_id = ?";
        $params = [$user_id];
        $types = "i";

        if (isset($filters['status']) && $filters['status'] !== '') {
            $sql .= " AND status = ?";
            $params[] = (int)$filters['status'];
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

    public function countqueries($user_id, $filters = [])
    {
        $sql = "SELECT COUNT(*) AS total FROM queries WHERE user_id=?";
        $params = [$user_id];
        $types = "i";

        if (isset($filters['status']) && $filters['status'] !== '') {
            $sql .= " AND status = ?";
            $params[] = (int)$filters['status'];
            $types .= "i";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }
}
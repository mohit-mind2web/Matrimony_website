<?php
namespace App\models;
use App\core\Model;

class UserMatches extends Model{
    public function getprofiles($user_id,$gender=null){
          if ($gender !== null) {
        $sql = "SELECT p.*, u.fullname ,TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) AS age,i.status AS requeststatus
                FROM profiles p
                JOIN users u ON p.user_id=u.id
                LEFT JOIN interests i
                ON i.sender_id = ?
               AND i.receiver_id = p.user_id
                WHERE p.gender=? AND p.user_id != ?
                ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $user_id,$gender, $user_id);
    } else {
        $sql = "SELECT p.*, u.fullname ,TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) AS age
                FROM profiles p
                JOIN users u ON p.user_id=u.id
                WHERE p.user_id != ?
                ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
}
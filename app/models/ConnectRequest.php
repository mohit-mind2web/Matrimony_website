<?php

namespace App\models;

use App\core\Model;

class ConnectRequest extends Model
{
    public function sendconnectrequest($sender_id, $receiver_id)
    {
        $sql = "INSERT INTO interests(sender_id,receiver_id,status)
        VALUES(?,?, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $sender_id, $receiver_id);
        return $stmt->execute();
    }
    public function getsentrequest($user_id)
    {
        $sql = "SELECT i.*,u.fullname,p.city,p.profile_photo FROM interests i
        JOIN users u ON i.receiver_id=u.id
        JOIN profiles p ON p.user_id = u.id
        WHERE sender_id=? 
        ORDER BY i.created_at DESC ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function checkExistingRequest($sender_id, $receiver_id)
    {
        $sql = "SELECT id FROM interests WHERE sender_id = ? AND receiver_id = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $sender_id, $receiver_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
    public function getreceivedrequest($user_id)
    {
        $sql = "SELECT i.*,u.fullname,p.city,p.profile_photo FROM interests i
        JOIN users u ON i.sender_id=u.id
        JOIN profiles p ON p.user_id = u.id
        WHERE receiver_id=?
        ORDER BY i.created_at DESC ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function updateStatus($requestId, $status)
    {
        $sql = "UPDATE interests SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $requestId);
        return $stmt->execute();
    }
    public function getRequestStatus($sender_id, $receiver_id)
    {
        $sql = "SELECT status FROM interests WHERE sender_id = ? AND receiver_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $sender_id, $receiver_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['status'] ?? null;
    }
}

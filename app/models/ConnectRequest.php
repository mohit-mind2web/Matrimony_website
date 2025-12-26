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
    public function getsentrequest($user_id, $limit = 2, $offset = 0)
    {
        $status = 0;
        $sql = "SELECT i.*,u.fullname,p.user_id,p.city,p.profile_photo FROM interests i
        JOIN users u ON i.receiver_id=u.id
        JOIN profiles p ON p.user_id = u.id
        WHERE i.sender_id=? AND i.status=?
        ORDER BY i.created_at DESC
        LIMIT ? OFFSET ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iiii', $user_id, $status, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function checkExistingRequest($sender_id, $receiver_id)
    {
        $sql = "SELECT id FROM interests WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
        LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iiii', $sender_id, $receiver_id, $receiver_id, $sender_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
    public function getreceivedrequest($user_id, $limit = 2, $offset = 0)
    {
        $status = 1;
        $sql = "SELECT i.*,u.fullname,p.user_id,p.city,p.profile_photo FROM interests i
        JOIN users u ON i.sender_id=u.id
        JOIN profiles p ON p.user_id = u.id
        WHERE i.receiver_id=? AND i.status=?
        ORDER BY i.created_at DESC
        LIMIT ? OFFSET ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iiii', $user_id, $status, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function updateStatus($requestid, $status)
    {
        $sql = "UPDATE interests SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $requestid);
        return $stmt->execute();
    }
    public function getRequestStatus($sender_id, $receiver_id)
    {
        $sql = "SELECT status FROM interests WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iiii', $sender_id, $receiver_id, $receiver_id, $sender_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['status'] ?? null;
    }

    public function countsentinterest($user_id)
    {
        $sql = "SELECT COUNT(*) AS total from interests where sender_id=? AND status=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }
    public function countreceivedinterest($user_id)
    {
        $sql = "SELECT COUNT(*) AS total from interests where receiver_id=? AND status=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getacceptrequest($user_id, $limit = 2, $offset = 0)
    {
        $status = 1;
        $sql = "SELECT i.*, u.fullname, p.user_id, p.city, p.profile_photo 
            FROM interests i
            JOIN users u ON i.receiver_id = u.id
            JOIN profiles p ON p.user_id = u.id
            WHERE i.sender_id=? AND i.status=?
            ORDER BY i.created_at DESC
            LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iiii', $user_id, $status, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getdeclinerequest($user_id, $limit = 2, $offset = 0)
    {
        $status = 2;
        $sql = "SELECT i.*, u.fullname, p.user_id, p.city, p.profile_photo 
            FROM interests i
            JOIN users u ON i.receiver_id = u.id
            JOIN profiles p ON p.user_id = u.id
            WHERE i.sender_id=? AND i.status=?
            ORDER BY i.created_at DESC
            LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iiii', $user_id, $status, $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countacceptinterest($user_id)
    {
        $sql = "SELECT COUNT(*) AS total FROM interests WHERE receiver_id=? AND status=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }
    public function countdeclineinterest($user_id)
    {
        $sql = "SELECT COUNT(*) AS total FROM interests WHERE receiver_id=? AND status=2";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }
}

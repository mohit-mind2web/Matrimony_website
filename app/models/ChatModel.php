<?php

namespace App\models;

use App\core\Model;

class ChatModel extends Model
{
    // Save new message
    public function sendMessage($senderId, $receiverId, $message)
    {
        $sql = "INSERT INTO messages (sender_id, receiver_id, message)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $senderId, $receiverId, $message);
        $stmt->execute();
        $stmt->close();
    }

    public function getChat($userId, $otherUserId)
    {
        $sql = "SELECT m.*,u.fullname FROM messages m
        JOIN users u ON m.receiver_id=u.id
                WHERE  (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
                ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iiii",
            $userId,
            $otherUserId,
            $otherUserId,
            $userId
        );
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Mark messages as read
    public function markAsRead($senderId, $receiverId)
    {
        $sql = "UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $senderId, $receiverId);
        $stmt->execute();
        $stmt->close();
    }
    public function getUserById($id)
    {
        $sql = "SELECT id, fullname FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //get connections
    public function getconnections($userId)
    {
        $sql = "SELECT i.*, p.profile_photo,  p.user_id,  u.fullname,
                       (SELECT COUNT(*) FROM messages m WHERE (m.sender_id = u.id AND m.receiver_id = ?) 
                          AND m.is_read = 0) as unread_count,
                       (SELECT MAX(created_at)  FROM messages m   WHERE (m.sender_id = u.id AND m.receiver_id = ?) 
                           OR (m.sender_id = ? AND m.receiver_id = u.id)) as latest_message_time
                FROM interests i
                JOIN users u ON (i.sender_id = u.id AND i.receiver_id = ?) 
                             OR (i.receiver_id = u.id AND i.sender_id = ?)
                JOIN profiles p ON u.id = p.user_id
                WHERE i.status = 1
                ORDER BY latest_message_time DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiiii", $userId, $userId, $userId, $userId, $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Check if two users are connected
    public function isconnected($userId, $otherUserId)
    {
        $sql = "SELECT 1 FROM interests 
                WHERE ((sender_id = ? AND receiver_id = ?) 
                OR (sender_id = ? AND receiver_id = ?)) 
                AND status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $userId, $otherUserId, $otherUserId, $userId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}

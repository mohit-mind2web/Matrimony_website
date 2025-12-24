<?php
namespace App\models;

use App\core\Model;

class ShortlistModel extends Model{
        public function addToShortlist($user_id, $profile_id)
    {
        $sql = "INSERT INTO shortlists (user_id, profile_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $user_id, $profile_id);
        return $stmt->execute();
    }

    }

<?php

namespace App\models;

use App\core\Model;

class ShortlistModel extends Model
{
   public function shortlistexists($user_id, $shortlist_id)
   {
      $sql = "SELECT id FROM shortlists where user_id=? AND shortlist_userid=?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param('ii', $user_id, $shortlist_id);
      $stmt->execute();
      return $stmt->get_result()->num_rows > 0;
   }

   public function shortlistadd($user_id, $shortlist_id)
   {
      $sql = "INSERT INTO shortlists(user_id,shortlist_userid) VALUES(?,?)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param('ii', $user_id, $shortlist_id);
      return $stmt->execute();
   }

   public function shortlistremove($user_id, $shortlist_id)
   {
      $sql = "DELETE FROM shortlists WHERE user_id=? AND shortlist_userid=?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param('ii', $user_id, $shortlist_id);
      return $stmt->execute();
   }
   public function getallshortlists($user_id, $limit=3, $offset = 0)
   {
      $sql = "SELECT p.*,u.fullname,i.status,i.sender_id,i.receiver_id,TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) AS age FROM shortlists s
           JOIN profiles p ON p.user_id=s.shortlist_userid
           JOIN users u ON p.user_id=u.id
            LEFT JOIN interests i 
        ON ((i.sender_id = ? AND i.receiver_id=p.user_id) OR (i.sender_id=p.user_id AND i.receiver_id = ?))
           WHERE s.user_id=?
           ORDER BY s.created_at DESC
           LIMIT ? OFFSET ?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param('iiiii', $user_id, $user_id, $user_id, $limit, $offset);
      $stmt->execute();
      return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   }
   //count shorlists users
   public function countshortlists($user_id)
   {
      $sql = "SELECT COUNT(*) AS total FROM shortlists WHERE user_id = ?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      return (int) $stmt->get_result()->fetch_assoc()['total'];
   }
}

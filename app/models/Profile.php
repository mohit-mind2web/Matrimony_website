<?php

namespace App\models;

use App\core\Model;

class Profile extends Model
{
    public function saveprofile($data)
    {
        $sql = "INSERT INTO profiles(user_id,profile_photo,mobileno,dob,gender,religion_id,education_id,
        profession_id,height_id,city,about_me) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "issssiissss",
            $data['user_id'],
            $data['profile_photo'],
            $data['mobileno'],
            $data['dob'],
            $data['gender'],
            $data['religion_id'],
            $data['education_id'],
            $data['profession_id'],
            $data['height_id'],
            $data['city'],
            $data['about_me']
        );
        return $stmt->execute();
    }

    public function markProfileCompleted($userid)
    {
        $sql = "UPDATE users SET profile_complete = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
    }
    public function getprofilebyid($user_id,$viewer_id)
    {
        $sql = "SELECT p.*,i.status,u.fullname,u.email,i.sender_id,i.receiver_id,(s.id IS NOT NULL) AS is_shortlist FROM profiles p 
         JOIN users u ON p.user_id=u.id
        LEFT JOIN interests i 
        ON ((i.sender_id = ? AND i.receiver_id=p.user_id) OR (i.sender_id=p.user_id AND i.receiver_id = ?))
         LEFT JOIN shortlists s ON s.user_id=? AND s.shortlist_userid=p.user_id
         WHERE p.user_id=?
         LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $viewer_id,$viewer_id,$viewer_id,$user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
     //edit
    public function getProfileByUserId($user_id)
    {
        $sql = "SELECT * FROM profiles WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($user_id, $data)
    {
        $sql = "UPDATE profiles SET profile_photo = ?, mobileno = ?, dob = ?, gender = ?, religion_id = ?, education_id = ?,
                profession_id = ?, height_id = ?, city = ?, about_me = ?
              WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssiiiiissi",
            $data['profile_photo'],
            $data['mobileno'],
            $data['dob'],
            $data['gender'],
            $data['religion_id'],
            $data['education_id'],
            $data['profession_id'],
            $data['height_id'],
            $data['city'],
            $data['about_me'],
            $user_id
        );

        return $stmt->execute();
    }
}

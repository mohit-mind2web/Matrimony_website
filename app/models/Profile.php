<?php
namespace App\models;
use App\core\Model;

class Profile extends Model{
    public function saveprofile($data){
        $sql="INSERT INTO profiles(user_id,profile_photo,mobileno,dob,gender,religion_id,education_id,
        profession_id,height_id,city,about_me) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $stmt=$this->conn->prepare($sql);
          $stmt->bind_param("issssiissss",
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
            $data['about_me']);
             return $stmt->execute();
    }

    public function markProfileCompleted($userid)
{
    $sql = "UPDATE users SET profile_complete = 1 WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
}
public function getprofilebyid($user_id){
         $sql="SELECT p.*,u.fullname FROM profiles p JOIN users u ON p.user_id=u.id
         WHERE user_id=?";
         $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
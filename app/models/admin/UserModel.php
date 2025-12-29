<?php
namespace App\models\admin;

use App\core\Model;

class UserModel extends Model{
    public function getallusers($limit=5,$offset=0){
        $sql="SELECT * from users WHERE role_id=2 ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt=$this->conn->prepare($sql);
        $stmt->bind_param('ii',$limit,$offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function statusupdate($user_id){
        $sql="UPDATE users SET status=IF(status=1,0,1) WHERE id=? ";
         $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
     public function getcountusers(){
        $sql="SELECT COUNT(*) AS total FROM users WHERE role_id=2";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];

    }
}
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
}
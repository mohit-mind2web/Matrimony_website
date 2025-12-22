<?php
namespace App\models;
use App\core\Model;

class UserModel extends Model {
    //functiom to insert register from data
    public function create($data){
        $sql="INSERT INTO users(profile_for,fullname,email,password,role_id) VALUES(?,?,?,?,?)";
        $stmt=$this->conn->prepare($sql);
        $stmt->bind_param('isssi',
        $data['profile_for'],
        $data['fullname'],
        $data['email'],
        $data['password'],
        $data['role_id']
    );
    return $stmt->execute();
    }

    //function to check email aready exist or not 
    public function emailExists($email){
         $stmt = $this->conn->prepare( "SELECT * FROM users WHERE email = ? LIMIT 1" );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows>0;
    }
    public function getuser($email)
{
    $stmt = $this->conn->prepare(
        "SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

}

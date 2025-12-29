<?php 
namespace App\models\admin;

use App\core\Model;

class DashboardModel extends Model{
    public function gettotalusers(){
        $sql="SELECT COUNT(*) AS totalusers,COUNT(CASE WHEN profile_complete=1 THEN 1 END) AS profilecomplete,
        COUNT(CASE WHEN profile_complete=0 THEN 1 END) AS profileincomplete
         FROM users WHERE role_id=2";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function gettotalprofiles(){
         $sql="SELECT COUNT(*) AS totalprofiles,COUNT(CASE WHEN gender=1 THEN 1 END) AS maleprofiles,
        COUNT(CASE WHEN gender=2 THEN 1 END) AS femaleprofiles
         FROM profiles";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
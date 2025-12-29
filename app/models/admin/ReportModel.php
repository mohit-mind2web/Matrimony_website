<?php
namespace App\models\admin;

use App\core\Model;

class ReportModel extends Model{
  public function getallreports($limit=5,$offset=0){
        $sql="SELECT r.*, u1.fullname AS reporter_name,u2.fullname AS reported_name
            FROM reports r
            JOIN users u1 ON r.reporter_id = u1.id
            JOIN users u2 ON r.reported_id = u2.id
            ORDER BY r.created_at DESC 
            LIMIT ? OFFSET ?";
        $stmt=$this->conn->prepare($sql);
        $stmt->bind_param('ii',$limit,$offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
     public function getcountreports(){
        $sql="SELECT COUNT(*) AS total FROM reports";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }
     public function updateStatus($reportId, $status)
    {
        $sql = "UPDATE reports SET status=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $reportId);
        return $stmt->execute();
    }
   
}
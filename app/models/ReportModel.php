<?php 
namespace App\models;

use App\core\Model;

class ReportModel extends Model{
    public function addreport($reporterId, $reportedUserId, $reason,  $description){
    $sql="INSERT INTO reports(reporter_id,reported_id,reason,description)
     VALUES(?,?,?,?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("iiss",$reporterId, $reportedUserId, $reason,  $description);
    return $stmt->execute();
    }


    public function alreadyReported($reporterId,$reportedId)
    {
        $sql = " SELECT id  FROM reports WHERE reporter_id = ? AND reported_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $reporterId, $reportedId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    
}
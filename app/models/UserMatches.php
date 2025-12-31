<?php

namespace App\models;

use App\core\Model;

class UserMatches extends Model
{
    public function getprofiles($user_id, $gender = null, $limit=null, $offset = 0)
    {
        if ($gender !== null) {
            $sql = "SELECT p.*, u.fullname,i.sender_id,i.receiver_id,(s.id IS NOT NULL) AS is_shortlist,TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) AS age,i.status
                FROM profiles p
                JOIN users u ON p.user_id=u.id
                LEFT JOIN interests i  ON ((i.sender_id = ? AND i.receiver_id = p.user_id) OR
                (i.sender_id = p.user_id AND i.receiver_id = ?))
                LEFT JOIN shortlists s ON s.user_id=? AND s.shortlist_userid=p.user_id
                WHERE p.gender=? AND p.user_id != ?
                ORDER BY p.created_at DESC
                LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiiiiii", $user_id, $user_id, $user_id, $gender, $user_id, $limit, $offset);
        } else {
            $sql = "SELECT p.*, u.fullname ,TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) AS age
                FROM profiles p
                JOIN users u ON p.user_id=u.id
                WHERE p.user_id != ?
                ORDER BY p.created_at DESC
                   LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $user_id, $limit, $offset);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function countprofiles($user_id, $gender = null)
    {
        if ($gender !== null) {
            $sql = "SELECT COUNT(*) AS total
                FROM profiles
                WHERE gender = ? AND user_id != ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $gender, $user_id);
        } else {
            $sql = "SELECT COUNT(*) AS total
                FROM profiles
                WHERE user_id != ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
        }

        $stmt->execute();
        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }

    public function filterProfiles($user_id, $filters, $limit = null, $offset = 0)
    {
        // Get opposite gender
        $profileModel = new Profile();
        $myprofile = $profileModel->getprofilebyid($user_id, $user_id);
        $gender = null;
        if ($myprofile) {
            $mygender = $myprofile['gender'];
            $gender = ($mygender == 1) ? 2 : 1;
        }

        $sql = "SELECT p.*, u.fullname,
            i.sender_id, i.receiver_id, i.status,
            (s.id IS NOT NULL) AS is_shortlist,
            TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) AS age
            FROM profiles p
            JOIN users u ON p.user_id = u.id
            LEFT JOIN interests i ON ((i.sender_id = ? AND i.receiver_id = p.user_id)
                                     OR (i.sender_id = p.user_id AND i.receiver_id = ?))
            LEFT JOIN shortlists s ON s.user_id = ? AND s.shortlist_userid = p.user_id
            WHERE p.user_id != ?";

        $params = [$user_id, $user_id, $user_id, $user_id];
        $types = "iiii";
        if ($gender !== null) {
            $sql .= " AND p.gender = ?";
            $params[] = $gender;
            $types .= "i";
        }
        if (!empty($filters['city'])) {
            $sql .= " AND p.city LIKE ?";
            $params[] = '%' . $filters['city'] . '%';
            $types .= "s";
        }

        if (!empty($filters['age_from'])) {
            $sql .= " AND TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) >= ?";
            $params[] = $filters['age_from'];
            $types .= "i";
        }

        if (!empty($filters['age_to'])) {
            $sql .= " AND TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) <= ?";
            $params[] = $filters['age_to'];
            $types .= "i";
        }

        if (!empty($filters['height_id'])) {
            $sql .= " AND p.height_id = ?";
            $params[] = $filters['height_id'];
            $types .= "i";
        }

        if (!empty($filters['religion_id'])) {
            $sql .= " AND p.religion_id = ?";
            $params[] = $filters['religion_id'];
            $types .= "i";
        }

        if (!empty($filters['education_id'])) {
            $sql .= " AND p.education_id = ?";
            $params[] = $filters['education_id'];
            $types .= "i";
        }

        if (!empty($filters['profession_id'])) {
            $sql .= " AND p.profession_id = ?";
            $params[] = $filters['profession_id'];
            $types .= "i";
        }
        $sql .= " ORDER BY p.created_at DESC";
         if ($limit) {
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";
    }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countFilteredProfiles($user_id, $filters)
    {
        $profileModel = new Profile();
        $myprofile = $profileModel->getprofilebyid($user_id, $user_id);
        $gender = null;
        if ($myprofile) {
            $mygender = $myprofile['gender'];
            $gender = ($mygender == 1) ? 2 : 1;
        }

        $sql = "SELECT COUNT(*) AS total
            FROM profiles p
            JOIN users u ON p.user_id = u.id
            WHERE p.user_id != ?";

        $params = [$user_id];
        $types = "i";

        if ($gender !== null) {
            $sql .= " AND p.gender = ?";
            $params[] = $gender;
            $types .= "i";
        }

        if (!empty($filters['city'])) {
            $sql .= " AND p.city LIKE ?";
            $params[] = '%' . $filters['city'] . '%';
            $types .= "s";
        }

        if (!empty($filters['age_from'])) {
            $sql .= " AND TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) >= ?";
            $params[] = $filters['age_from'];
            $types .= "i";
        }

        if (!empty($filters['age_to'])) {
            $sql .= " AND TIMESTAMPDIFF(YEAR, p.dob, CURDATE()) <= ?";
            $params[] = $filters['age_to'];
            $types .= "i";
        }

        if (!empty($filters['height_id'])) {
            $sql .= " AND p.height_id = ?";
            $params[] = $filters['height_id'];
            $types .= "i";
        }

        if (!empty($filters['religion_id'])) {
            $sql .= " AND p.religion_id = ?";
            $params[] = $filters['religion_id'];
            $types .= "i";
        }

        if (!empty($filters['education_id'])) {
            $sql .= " AND p.education_id = ?";
            $params[] = $filters['education_id'];
            $types .= "i";
        }

        if (!empty($filters['profession_id'])) {
            $sql .= " AND p.profession_id = ?";
            $params[] = $filters['profession_id'];
            $types .= "i";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return (int) $stmt->get_result()->fetch_assoc()['total'];
    }

      public function disconnect($user_id, $other_user_id)
    {
        $sql = "UPDATE interests  SET status = 3  WHERE  (sender_id = ? AND receiver_id = ?)  OR
                (sender_id = ? AND receiver_id = ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iiii",
            $user_id,
            $other_user_id,
            $other_user_id,
            $user_id
        );

        return $stmt->execute();
    }
}

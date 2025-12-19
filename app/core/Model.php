<?php
namespace App\core;

class Model{
    protected $conn;
     public function __construct(){
        $this->conn = Database::connect();
    }
}
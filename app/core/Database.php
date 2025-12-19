<?php 

class Database{
    private static $conn=null;
    public static function connect(){
        if(self::$conn==null){
            $host=$_ENV['DB_HOST'] ?? 'localhost';
            $user=$_ENV['DB_USER'] ?? 'root';
            $pass=$_ENV['DB_PASS'] ?? '';
            $name=$_ENV['DB_NAME'] ??'test';
        }
    }
}


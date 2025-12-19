<?php 
namespace App\core;
use mysqli;
class Database{
    private static $conn=null;
    public static function connect(){
        if(self::$conn===null){
            $host=$_ENV['DB_HOST'] ?? 'localhost';
            $user=$_ENV['DB_USER'] ?? 'root';
            $pass=$_ENV['DB_PASS'] ?? '';
            $name=$_ENV['DB_NAME'] ??'test';
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            
            try{
                self::$conn=new mysqli($host,$user,$pass,$name);
                self::$conn->set_charset('utf8');
            }
            catch(\mysqli_sql_exception $e){
                die("Database connection failed". $e->getMessage());
            }
        }
        return self::$conn;
    }
}


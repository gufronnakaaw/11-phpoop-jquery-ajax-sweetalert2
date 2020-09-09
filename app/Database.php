<?php 

class Database 
{
    
    protected $host = 'localhost';
    protected $username = 'root';
    protected $pass = '';
    protected $dbName = 'perpustakaan';

    protected $conn;
    
    public function __construct()
    {
        if(!isset($this->conn)){
            $this->conn = new mysqli($this->host,$this->username,$this->pass,$this->dbName);

            if($this->conn->connect_errno){
                echo "failed connect db";
                exit();
            }
        }
    }

}

<?php 

class DatabaseConfig {
    
    public $conn;    
    public function __construct($host, $username, $password, $database){

        if (!isset($this->conn)) {
            
            $this->conn = new mysqli($host, $username, $password, $database);
            
            if (!$this->conn) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
    }

    public function __destruct(){
        $this->conn->close();
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>

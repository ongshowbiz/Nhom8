<?php
class Database {
    public $host = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "scm_db";  

    private $connect;

    public function __construct() {
        $this->connect = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        $this->connect->set_charset("utf8");
        if ($this->connect->connect_error) {
            die("Kết nối thất bại: " . $this->connect->connect_error);
        }
        return $this->connect;
    }

    public function getConnection() {
        return $this->connect;
    }

    public function query($sql) {
        return $this->connect->query($sql);
    }
}
?>
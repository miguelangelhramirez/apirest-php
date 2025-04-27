
<?php

class Database {

    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host     = $_ENV["DB_HOST"];
        $this->db_name  = $_ENV["DB_NAME"];
        $this->username = $_ENV["DB_USER"];
        $this->password = $_ENV["DB_PASSWORD"];
    }

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username, $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}

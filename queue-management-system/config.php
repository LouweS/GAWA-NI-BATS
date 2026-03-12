<?php
class Database {
    private $host = "127.0.0.1";
    private $port = "3307";
    private $db_name = "queuing_system";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Return JSON instead of echoing
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $exception->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}

session_start();
?>
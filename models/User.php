
<?php
require_once "config/database.php";

class User {
    private $conn;
    private $table = "users";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        try {
            $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO $this->table (email, nombre, password, cargo, rol) 
                                        VALUES (:email, :nombre, :password, :cargo, :rol)");
            $stmt->bindParam(":email", $data["email"]);
            $stmt->bindParam(":nombre", $data["nombre"]);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":cargo", $data["cargo"]);
            $stmt->bindParam(":rol", $data["rol"]);
            if($stmt->execute()) {
                return $this->conn->lastInsertId();
            }else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());      
        }
        
    }

    public function update($id, $data) {
        $query = "UPDATE $this->table SET email = :email, nombre = :nombre, cargo = :cargo, rol = :rol";
        if (!empty($data["password"])) {
            $query .= ", password = :password";
        }
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $data["email"]);
        $stmt->bindParam(":nombre", $data["nombre"]);
        $stmt->bindParam(":cargo", $data["cargo"]);
        $stmt->bindParam(":rol", $data["rol"]);
        $stmt->bindParam(":id", $id);

        if (!empty($data["password"])) {
            $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);
            $stmt->bindParam(":password", $hashedPassword);
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function setToken($id, $token) {
        $query = "UPDATE $this->table SET token = :token WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}

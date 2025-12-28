<?php
require_once __DIR__ . '/../../config.php';

class BaseDao {
    protected $table_name;
    protected $primary_key;
    protected $connection;

    public function __construct($table_name, $primary_key = 'id') {
        $this->table_name = $table_name;
        $this->primary_key = $primary_key;
        $this->connection = Database::connect();
    }

    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table_name);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table_name . " WHERE " . $this->primary_key . " = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO " . $this->table_name . " ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        // Remove the primary key from data if it exists to avoid conflicts
        if (isset($data[$this->primary_key])) {
            unset($data[$this->primary_key]);
        }
        if (isset($data['id'])) {
            unset($data['id']);
        }
        
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        
        // Use primary_key_param to avoid naming conflicts
        $sql = "UPDATE " . $this->table_name . " SET $fields WHERE " . $this->primary_key . " = :primary_key_param";
        $stmt = $this->connection->prepare($sql);
        
        // Add the ID with a safe parameter name
        $data['primary_key_param'] = $id;
        
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table_name . " WHERE " . $this->primary_key . " = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Helper methods for custom queries
    protected function query($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    protected function query_unique($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt->fetch();
    }

    public function add($entity) {
        $columns = implode(", ", array_keys($entity));
        $placeholders = ":" . implode(", :", array_keys($entity));
        $sql = "INSERT INTO " . $this->table_name . " ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($entity);
        $entity[$this->primary_key] = $this->connection->lastInsertId();
        return $entity;
    }
}
?>
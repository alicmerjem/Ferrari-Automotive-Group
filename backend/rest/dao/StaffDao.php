<?php
require_once 'BaseDao.php';

class StaffDao extends BaseDao {
    public function __construct() {
        parent::__construct("staff", "staff_id");
    }

    // Custom method to get staff by position
    public function getByPosition($position) {
        $stmt = $this->connection->prepare("SELECT * FROM staff WHERE position = :position");
        $stmt->bindParam(':position', $position);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Custom method to search staff by name
    public function searchByName($name) {
        $stmt = $this->connection->prepare("SELECT * FROM staff WHERE first_name LIKE :name OR last_name LIKE :name");
        $searchName = "%" . $name . "%";
        $stmt->bindParam(':name', $searchName);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
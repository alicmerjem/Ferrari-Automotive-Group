<?php
require_once 'BaseDao.php';

class CarDao extends BaseDao {
    public function __construct() {
        parent::__construct("cars");
    }

    // Custom method to get available cars only
    public function getAvailableCars() {
        $stmt = $this->connection->prepare("SELECT * FROM cars WHERE status = 'available'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Custom method to get cars by category
    public function getCarsByCategory($category) {
        $stmt = $this->connection->prepare("SELECT * FROM cars WHERE category = :category AND status = 'available'");
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Custom method to search cars by model
    public function searchCarsByModel($searchTerm) {
        $stmt = $this->connection->prepare("SELECT * FROM cars WHERE model LIKE :search AND status = 'available'");
        $searchTerm = "%" . $searchTerm . "%";
        $stmt->bindParam(':search', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
<?php
require_once 'BaseDao.php';

class ContactDao extends BaseDao {
    public function __construct() {
        parent::__construct("contacts");
    }

    // Custom method to get contacts by car (if someone inquired about a specific car)
    public function getByCarId($car_id) {
        $stmt = $this->connection->prepare("SELECT * FROM contacts WHERE car_id = :car_id");
        $stmt->bindParam(':car_id', $car_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Custom method to get recent contacts
    public function getRecentContacts($limit = 10) {
        $stmt = $this->connection->prepare("SELECT * FROM contacts ORDER BY submitted_at DESC LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
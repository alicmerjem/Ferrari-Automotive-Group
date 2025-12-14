<?php
require_once 'BaseDao.php';

class ContactDao extends BaseDao {
    public function __construct() {
        parent::__construct("contacts"); // default primary key 'id'
    }

    // Get contacts by car
    public function getByCarId($car_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE car_id = :car_id";
        return $this->query($query, ['car_id' => $car_id])->fetchAll();
    }

    // Get recent contacts
    public function getRecentContacts($limit = 10) {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY submitted_at DESC LIMIT :limit";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>

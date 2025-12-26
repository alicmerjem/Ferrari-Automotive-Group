<?php
require_once 'BaseDao.php';

class ContactDao extends BaseDao {
    public function __construct() {
        parent::__construct("contacts", "contact_id");
    }

    public function getByCarId($car_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE car_id = :car_id";
        return $this->query($query, ['car_id' => $car_id])->fetchAll();
    }

    public function getRecentContacts($limit = 10) {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY submitted_at DESC LIMIT :limit";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>

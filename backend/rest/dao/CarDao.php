<?php
require_once 'BaseDao.php';

class CarDao extends BaseDao {
    public function __construct() {
        parent::__construct("cars", "car_id");
    }

    public function getAvailableCars() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = 'available'";
        return $this->query($query)->fetchAll();
    }

    public function getCarsByCategory($category) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category = :category AND status = 'available'";
        return $this->query($query, ['category' => $category])->fetchAll();
    }

    public function searchCarsByModel($searchTerm) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE model LIKE :search AND status = 'available'";
        $searchTerm = "%" . $searchTerm . "%";
        return $this->query($query, ['search' => $searchTerm])->fetchAll();
    }
}
?>

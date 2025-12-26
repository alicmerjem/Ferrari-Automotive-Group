<?php
require_once 'BaseDao.php';

class ServiceDao extends BaseDao {
    public function __construct() {
        parent::__construct("services", "service_id");
    }

    public function getByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id ORDER BY created_at DESC";
        return $this->query($query, ['user_id' => $user_id])->fetchAll();
    }

    public function getByStatus($status) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = :status ORDER BY preferred_dt ASC";
        return $this->query($query, ['status' => $status])->fetchAll();
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE service_id = :id";
        return $this->query($query, ['status' => $status, 'id' => $id]);
    }

    public function getByCarId($car_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE car_id = :car_id ORDER BY created_at DESC";
        return $this->query($query, ['car_id' => $car_id])->fetchAll();
    }
}
?>

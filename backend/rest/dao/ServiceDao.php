<?php
require_once 'BaseDao.php';

class ServiceDao extends BaseDao {
    public function __construct() {
        parent::__construct("services", "service_id");
    }

    // Custom method to get services by user
    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM services WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Custom method to get services by status
    public function getByStatus($status) {
        $stmt = $this->connection->prepare("SELECT * FROM services WHERE status = :status ORDER BY preferred_dt ASC");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Custom method to update service status
    public function updateStatus($service_id, $status) {
        $stmt = $this->connection->prepare("UPDATE services SET status = :status WHERE service_id = :service_id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':service_id', $service_id);
        return $stmt->execute();
    }

    // Custom method to get services by car
    public function getByCarId($car_id) {
        $stmt = $this->connection->prepare("SELECT * FROM services WHERE car_id = :car_id ORDER BY created_at DESC");
        $stmt->bindParam(':car_id', $car_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
<?php
require_once 'BaseDao.php';

class TestDriveDao extends BaseDao {
    public function __construct() {
        parent::__construct("test_drives", "test_drive_id");
    }

    // Custom method to get test drives by user
    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM test_drives WHERE user_id = :user_id ORDER BY requested_at DESC");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Custom method to get test drives by status
    public function getByStatus($status) {
        $stmt = $this->connection->prepare("SELECT * FROM test_drives WHERE status = :status ORDER BY preferred_date ASC");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Custom method to update test drive status
    public function updateStatus($test_drive_id, $status) {
        $stmt = $this->connection->prepare("UPDATE test_drives SET status = :status WHERE test_drive_id = :test_drive_id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':test_drive_id', $test_drive_id);
        return $stmt->execute();
    }
}
?>
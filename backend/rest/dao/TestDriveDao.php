<?php
require_once 'BaseDao.php';

class TestDriveDao extends BaseDao {
    public function __construct() {
        parent::__construct("test_drives", "test_drive_id");
    }

    public function getByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id ORDER BY requested_at DESC";
        return $this->query($query, ['user_id' => $user_id])->fetchAll();
    }

    public function getByStatus($status) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = :status ORDER BY preferred_date ASC";
        return $this->query($query, ['status' => $status])->fetchAll();
    }

    public function updateStatus($test_drive_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE test_drive_id = :id";
        return $this->query($query, ['status' => $status, 'id' => $test_drive_id])->rowCount() > 0;
    }
}
?>

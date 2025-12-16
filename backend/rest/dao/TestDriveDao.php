<?php
require_once 'BaseDao.php';

class TestDriveDao extends BaseDao {
    public function __construct() {
        parent::__construct("test_drives"); // removed custom primary key, like their style
    }

    // Get test drives by user
    public function getByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id ORDER BY requested_at DESC";
        return $this->query($query, ['user_id' => $user_id])->fetchAll();
    }

    // Get test drives by status
    public function getByStatus($status) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = :status ORDER BY preferred_date ASC";
        return $this->query($query, ['status' => $status])->fetchAll();
    }

    // Update test drive status
    public function updateStatus($test_drive_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        return $this->query($query, ['status' => $status, 'id' => $test_drive_id])->rowCount() > 0;
    }
}
?>

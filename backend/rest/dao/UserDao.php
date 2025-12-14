<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("users"); // removed custom primary key, like their style
    }

    // Get user by email
    public function getByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }

    // Check if email exists
    public function emailExists($email) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE email = :email";
        $result = $this->query_unique($query, ['email' => $email]);
        return $result['count'] > 0;
    }

    // Get users by role
    public function getByRole($role) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE role = :role";
        return $this->query($query, ['role' => $role])->fetchAll();
    }

    // Promote a user to admin
    public function promoteToAdmin($user_id) {
        $query = "UPDATE " . $this->table_name . " SET role = 'admin' WHERE id = :id";
        return $this->query($query, ['id' => $user_id])->rowCount() > 0;
    }

    // Check if a user is admin
    public function isAdmin($user_id) {
        $query = "SELECT role FROM " . $this->table_name . " WHERE id = :id";
        $user = $this->query_unique($query, ['id' => $user_id]);
        return $user && $user['role'] === 'admin';
    }
}
?>

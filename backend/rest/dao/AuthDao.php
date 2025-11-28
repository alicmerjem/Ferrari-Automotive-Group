<?php
require_once 'BaseDao.php';

class AuthDao extends BaseDao {
    public function __construct() {
        parent::__construct("users", "user_id");
    }

    public function get_user_by_email($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
}
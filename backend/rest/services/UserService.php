<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';

class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDao());
    }

    // Business logic: Create user with validation
    public function create($data) {
        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }

        // Validate password strength
        if (strlen($data['password_hash']) < 6) {
            throw new Exception('Password must be at least 6 characters');
        }

        return parent::create($data);
    }

    // Get user by email
    public function getByEmail($email) {
        return $this->dao->getByEmail($email);
    }

    // Get users by role
    public function getByRole($role) {
        return $this->dao->getByRole($role);
    }
}
?>

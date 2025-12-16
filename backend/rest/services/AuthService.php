<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
require_once __DIR__ . '/../../data/roles.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct($this->auth_dao);
    }

    // Get user by email
    public function get_user_by_email($email){
        return $this->auth_dao->get_user_by_email($email);
    }

    // Register new user
    public function register($data) {
        if (empty($data['email']) || empty($data['password']) || empty($data['first_name']) || empty($data['last_name'])) {
            return ['success' => false, 'error' => 'Email, password, first name, and last name are required.'];
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email format.'];
        }

        $email_exists = $this->auth_dao->get_user_by_email($data['email']);
        if($email_exists){
            return ['success' => false, 'error' => 'Email already registered.'];
        }

        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        unset($data['password']); // Remove plain password
        $data['role'] = 'user'; // Default role

        $user_created = parent::create($data);
        if (!$user_created) {
            return ['success' => false, 'error' => 'Failed to create user.'];
        }

        $user = $this->auth_dao->get_user_by_email($data['email']);
        unset($user['password_hash']);

        return ['success' => true, 'data' => $user];
    }

    // User login
    public function login($data) {
        if (empty($data['email']) || empty($data['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }

        $user = $this->auth_dao->get_user_by_email($data['email']);
        if(!$user || !password_verify($data['password'], $user['password_hash'])) {
            return ['success' => false, 'error' => 'Invalid username or password.'];
        }

        unset($user['password_hash']);

        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24) // 1 day expiration
        ];

        $token = JWT::encode($jwt_payload, Config::JWT_SECRET(), 'HS256');

        return ['success' => true, 'data' => array_merge($user, ['token' => $token])];
    }
}
?>

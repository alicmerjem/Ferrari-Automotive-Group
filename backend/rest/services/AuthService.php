<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    public function __construct() {
        parent::__construct(new AuthDao());
    }

    // Custom method for authentication
    public function get_user_by_email($email){
        return $this->dao->get_user_by_email($email);
    }

    // Business logic: User registration
    public function register($data) {
        // Validation: Required fields
        if (empty($data['email']) || empty($data['password']) || empty($data['first_name']) || empty($data['last_name'])) {
            throw new Exception('Email, password, first name, and last name are required.');
        }

        // Validation: Email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        // Validation: Check if email exists
        $email_exists = $this->dao->get_user_by_email($data['email']);
        if($email_exists){
            throw new Exception('Email already registered.');
        }

        // Hash password and set default role
        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        unset($data['password']); // Remove plain password
        $data['role'] = 'customer'; // Default role

        // insert the user, return true or false
        $result = parent::create($data);

        if (!$result) {
            throw new Exception('Failed to create user');
        }

        // fetch the newly created user
        $user = $this->dao->get_user_by_email($data['email']);

        // remove password hash 
        unset($user['password_hash']);

        return $user;             
    }

    // Business logic: User login
    public function login($data) {
        // Validation: Required fields
        if (empty($data['email']) || empty($data['password'])) {
            throw new Exception('Email and password are required.');
        }

        $user = $this->dao->get_user_by_email($data['email']);
        if(!$user){
            throw new Exception('Invalid username or password.');
        }

        if(!password_verify($data['password'], $user['password_hash'])) {
            throw new Exception('Invalid username or password.');
        }

        unset($user['password_hash']);
      
        // Generate JWT token
        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24) // valid for day
        ];

        $token = JWT::encode(
            $jwt_payload,
            Database::JWT_SECRET(),
            'HS256'
        );

        return array_merge($user, ['token' => $token]);             
    }
}
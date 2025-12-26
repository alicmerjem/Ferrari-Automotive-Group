<?php
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/rest/services/BaseService.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/data/roles.php';
require_once __DIR__ . '/config.php';

require_once __DIR__ . '/rest/services/AuthService.php';
require_once __DIR__ . '/rest/services/CarService.php';
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/StaffService.php';
require_once __DIR__ . '/rest/services/ContactService.php';
require_once __DIR__ . '/rest/services/ServiceService.php';
require_once __DIR__ . '/rest/services/TestdriveService.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Register services and middleware
Flight::register('auth_service', 'AuthService');
Flight::register('auth_middleware', 'AuthMiddleware');
Flight::register('carService', 'CarService');
Flight::register('userService', 'UserService');
Flight::register('staffService', 'StaffService');
Flight::register('contactService', 'ContactService');
Flight::register('serviceService', 'ServiceService');
Flight::register('testdriveService', 'TestdriveService');

// Global token verification before routes
Flight::before('start', function (&$params, &$output) {
    $url = Flight::request()->url;

    // Public routes
    if (
        strpos($url, '/auth/login') !== false ||
        strpos($url, '/auth/register') !== false
    ) {
        return TRUE;
    }

    $authHeader = Flight::request()->getHeader("Authorization");

    if (!$authHeader) {
        Flight::halt(401, "Missing Authorization header");
    }

    // Extract token and clean it thoroughly
    if (strpos($authHeader, 'Bearer ') === 0) {
        $token = substr($authHeader, 7);
        // Remove ALL whitespace and control characters
        $token = preg_replace('/[\s\x00-\x1F\x7F]/', '', $token);
    } else {
        Flight::halt(401, "Invalid Authorization header format");
    }

    Flight::auth_middleware()->verifyToken($token);
});

// Include routes
require_once __DIR__ . '/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/car_routes.php';
require_once __DIR__ . '/rest/routes/user_routes.php';
require_once __DIR__ . '/rest/routes/staff_routes.php';
require_once __DIR__ . '/rest/routes/contact_routes.php';
require_once __DIR__ . '/rest/routes/service_routes.php';
require_once __DIR__ . '/rest/routes/testdrive_routes.php';

// Root endpoint
Flight::route('/', function() {
    echo json_encode([
        'message' => 'Ferrari Automotive Group API',
        'version' => '1.0',
        'endpoints' => [
            '/auth/register' => 'User registration',
            '/auth/login' => 'User login',
            '/api/cars' => 'Car management',
            '/api/users' => 'User management',
            '/api/staff' => 'Staff management',
            '/api/contacts' => 'Contact inquiries',
            '/api/services' => 'Service appointments',
            '/api/testdrives' => 'Test drive bookings'
        ]
    ]);
});

Flight::start();
?>

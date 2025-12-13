<?php
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/rest/services/BaseService.php';

require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/data/roles.php';

require_once __DIR__ . '/rest/services/AuthService.php';
Flight::register('auth_service', 'AuthService');

Flight::register('auth_middleware', 'AuthMiddleware');

require_once __DIR__ . '/rest/services/CarService.php';
Flight::register('carService', 'CarService');

require_once __DIR__ . '/rest/services/UserService.php';
Flight::register('userService', 'UserService');

require_once __DIR__ . '/rest/services/StaffService.php';
Flight::register('staffService', 'StaffService');

require_once __DIR__ . '/rest/services/ContactService.php';
Flight::register('contactService', 'ContactService');

require_once __DIR__ . '/rest/services/ServiceService.php';
Flight::register('serviceService', 'ServiceService');

require_once __DIR__ . '/rest/services/TestdriveService.php';
Flight::register('testdriveService', 'TestdriveService');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// This wildcard route intercepts all requests and applies authentication checks before proceeding.
Flight::route('/*', function() {
    // Allow public access to auth routes and root
    if(
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0 ||
        Flight::request()->url === '/'
    ) {
        return TRUE;
    } else {
        try {
            $token = Flight::request()->getHeader("Authorization");
            // Use the middleware instead of direct JWT decoding
            if(Flight::auth_middleware()->verifyToken($token))
                return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});

require_once __DIR__ . '/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/car_routes.php';
require_once __DIR__ . '/rest/routes/user_routes.php';
require_once __DIR__ . '/rest/routes/staff_routes.php';
require_once __DIR__ . '/rest/routes/contact_routes.php';
require_once __DIR__ . '/rest/routes/service_routes.php';
require_once __DIR__ . '/rest/routes/testdrive_routes.php';

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
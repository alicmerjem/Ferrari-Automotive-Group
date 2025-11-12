<?php
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/rest/services/BaseService.php';

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
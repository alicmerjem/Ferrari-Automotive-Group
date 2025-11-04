<?php
require_once 'flight/Flight.php';

require_once 'rest/routes/car_routes.php';
require_once 'rest/routes/user_routes.php';
require_once 'rest/routes/staff_routes.php';
require_once 'rest/routes/contact_routes.php';
require_once 'rest/routes/service_routes.php';
require_once 'rest/routes/testdrive_routes.php';

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
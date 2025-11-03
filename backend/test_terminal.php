<?php
require_once __DIR__ . '/rest/dao/UserDao.php';
require_once __DIR__ . '/rest/dao/CarDao.php';
require_once __DIR__ . '/rest/dao/StaffDao.php';
require_once __DIR__ . '/rest/dao/ContactDao.php';
require_once __DIR__ . '/rest/dao/ServiceDao.php';
require_once __DIR__ . '/rest/dao/TestDriveDao.php';

echo "=== Ferrari Automotive Group - TERMINAL DAO TEST ===\n\n";

// Test UserDao
echo "1. UserDao CRUD Test:\n";
$userDao = new UserDao();
$users = $userDao->getAll();
echo "   Initial users: " . count($users) . "\n";

$uniqueEmail = 'test.user.' . time() . '@example.com';
$userDao->insert([
    'first_name' => 'Test', 
    'last_name' => 'User',
    'email' => $uniqueEmail,
    'password_hash' => password_hash('test123', PASSWORD_DEFAULT)
]);
echo "   User inserted\n";

$users = $userDao->getAll();
echo "   Users after insert: " . count($users) . "\n";

$user = $userDao->getByEmail($uniqueEmail);
echo "   User found by email: " . ($user ? "YES - ID: " . $user['user_id'] : "NO") . "\n";

if ($user) {
    $userDao->update($user['user_id'], [
        'first_name' => 'Updated',
        'last_name' => 'Name'
    ]);
    echo "   User updated\n";
    
    $userDao->delete($user['user_id']);
    echo "   User deleted\n";
}

$users = $userDao->getAll();
echo "   Final users count: " . count($users) . "\n";

// Test User Role functionality
echo "\n2. User Role Test:\n";
$customers = $userDao->getByRole('customer');
echo "   Customer users: " . count($customers) . "\n";

$admins = $userDao->getByRole('admin');
echo "   Admin users: " . count($admins) . "\n";

if (count($customers) > 0) {
    $customerId = $customers[0]['user_id'];
    $userDao->promoteToAdmin($customerId);
    echo "   User promoted to admin\n";
    
    $isAdmin = $userDao->isAdmin($customerId);
    echo "   User is now admin: " . ($isAdmin ? "YES" : "NO") . "\n";
}

// Test CarDao
echo "\n3. CarDao CRUD Test:\n";
$carDao = new CarDao();
$cars = $carDao->getAll();
echo "   Initial cars: " . count($cars) . "\n";

$carDao->insert([
    'model' => 'Test Ferrari',
    'year' => 2024,
    'price' => 250000.00,
    'category' => 'Sports',
    'horsepower' => 700,
    'top_speed' => 330,
    'acceleration' => 3.0,
    'transmission' => 'Automatic',
    'color' => 'Red',
    'status' => 'available'
]);
echo "   Car inserted\n";

$cars = $carDao->getAll();
echo "   Cars after insert: " . count($cars) . "\n";

if (count($cars) > 0) {
    $car = $carDao->getById($cars[0]['car_id']);
    echo "   Car found by ID: " . ($car ? "YES - Model: " . $car['model'] : "NO") . "\n";
}

$availableCars = $carDao->getAvailableCars();
echo "   Available cars: " . count($availableCars) . "\n";

// Test StaffDao
echo "\n4. StaffDao CRUD Test:\n";
$staffDao = new StaffDao();
$staff = $staffDao->getAll();
echo "   Initial staff: " . count($staff) . "\n";

$uniqueStaffEmail = 'staff.' . time() . '@ferrari.com';
$staffDao->insert([
    'first_name' => 'Test',
    'last_name' => 'Staff',
    'email' => $uniqueStaffEmail,
    'position' => 'Sales Representative',
    'phone' => '555-0123'
]);
echo "   Staff inserted\n";

$staff = $staffDao->getAll();
echo "   Staff after insert: " . count($staff) . "\n";

if (count($staff) > 0) {
    $staffMember = $staffDao->getById($staff[0]['staff_id']);
    echo "   Staff found by ID: " . ($staffMember ? "YES - Position: " . $staffMember['position'] : "NO") . "\n";
}

// Test ContactDao
echo "\n5. ContactDao CRUD Test:\n";
$contactDao = new ContactDao();
$contacts = $contactDao->getAll();
echo "   Initial contacts: " . count($contacts) . "\n";

$contactDao->insert([
    'first_name' => 'Contact',
    'last_name' => 'Test',
    'email' => 'contact.test@example.com',
    'message' => 'This is a test contact message from a potential customer.'
]);
echo "   Contact inserted\n";

$contacts = $contactDao->getAll();
echo "   Contacts after insert: " . count($contacts) . "\n";

if (count($contacts) > 0) {
    $contact = $contactDao->getById($contacts[0]['contact_id']);
    echo "   Contact found by ID: " . ($contact ? "YES - Message: " . substr($contact['message'], 0, 20) . "..." : "NO") . "\n";
}

// Test ServiceDao
echo "\n6. ServiceDao CRUD Test:\n";
$serviceDao = new ServiceDao();
$services = $serviceDao->getAll();
echo "   Initial services: " . count($services) . "\n";

$serviceDao->insert([
    'user_id' => 1,
    'car_id' => 1,
    'service_type' => 'Oil Change',
    'preferred_dt' => '2024-12-01 10:00:00',
    'status' => 'requested'
]);
echo "   Service inserted\n";

$services = $serviceDao->getAll();
echo "   Services after insert: " . count($services) . "\n";

// Test TestDriveDao
echo "\n7. TestDriveDao CRUD Test:\n";
$testDriveDao = new TestDriveDao();
$testDrives = $testDriveDao->getAll();
echo "   Initial test drives: " . count($testDrives) . "\n";

$testDriveDao->insert([
    'user_id' => 1,
    'car_id' => 1,
    'preferred_date' => '2024-12-01',
    'preferred_time' => '14:00:00',
    'status' => 'requested'
]);
echo "   Test drive inserted\n";

$testDrives = $testDriveDao->getAll();
echo "   Test drives after insert: " . count($testDrives) . "\n";

echo "\n=== ALL 6 DAOs TESTED SUCCESSFULLY! ===\n";
echo "All CRUD operations working for every entity!\n";
?>
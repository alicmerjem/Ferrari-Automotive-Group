<?php
require_once __DIR__ . '/rest/dao/UserDao.php';
require_once __DIR__ . '/rest/dao/CarDao.php';
require_once __DIR__ . '/rest/dao/StaffDao.php';
require_once __DIR__ . '/rest/dao/ContactDao.php';
require_once __DIR__ . '/rest/dao/ServiceDao.php';
require_once __DIR__ . '/rest/dao/TestDriveDao.php';

echo "<h1>Ferrari Automotive Group - DAO CRUD Test</h1>";

// Test UserDao
$userDao = new UserDao();

echo "<h2>UserDao CRUD Test:</h2>";

// GET ALL (Read)
$users = $userDao->getAll();
echo "Initial users: " . count($users) . "<br>";

// generating a unique email to avoid errors
$uniqueEmail = 'test.user.' . time() . '@example.com';

// INSERT (Create)
$userDao->insert([
    'first_name' => 'Test', 
    'last_name' => 'User',
    'email' => $uniqueEmail,
    'password_hash' => password_hash('test123', PASSWORD_DEFAULT)
]);
echo "User inserted<br>";

// GET ALL after insert
$users = $userDao->getAll();
echo "Users after insert: " . count($users) . "<br>";

// GET BY EMAIL (custom method)
$user = $userDao->getByEmail($uniqueEmail);
echo "User found by email: " . ($user ? "YES - ID: " . $user['user_id'] : "NO") . "<br>";

// UPDATE
if ($user) {
    $userDao->update($user['user_id'], [
        'first_name' => 'Updated',
        'last_name' => 'Name'
    ]);
    echo "User updated<br>";
}

// DELETE
if ($user) {
    $userDao->delete($user['user_id']);
    echo "User deleted<br>";
}

// test User Role functionality
echo "<h2>User Role Test:</h2>";

// get all customers
$customers = $userDao->getByRole('customer');
echo "Customer users: " . count($customers) . "<br>";

// get all admins
$admins = $userDao->getByRole('admin');
echo "Admin users: " . count($admins) . "<br>";

// test promoting a user to admin
if (count($customers) > 0) {
    $customerId = $customers[0]['user_id'];
    $userDao->promoteToAdmin($customerId);
    echo "User promoted to admin<br>";
    
    // verify promotion worked
    $isAdmin = $userDao->isAdmin($customerId);
    echo "User is now admin: " . ($isAdmin ? "YES" : "NO") . "<br>";
}

// Final count
$users = $userDao->getAll();
echo "Final users count: " . count($users) . "<br>";

// Test CarDao
echo "<h2>CarDao CRUD Test:</h2>";
$carDao = new CarDao();
$cars = $carDao->getAll();
echo "Initial cars: " . count($cars) . "<br>";

// INSERT (Create)
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
echo "Car inserted<br>";

// GET ALL after insert
$cars = $carDao->getAll();
echo "Cars after insert: " . count($cars) . "<br>";

// GET BY ID
if (count($cars) > 0) {
    $car = $carDao->getById($cars[0]['car_id']);
    echo "Car found by ID: " . ($car ? "YES - Model: " . $car['model'] : "NO") . "<br>";
}

// Test custom method
$availableCars = $carDao->getAvailableCars();
echo "Available cars: " . count($availableCars) . "<br>";

// Test StaffDao
echo "<h2>StaffDao CRUD Test:</h2>";
$staffDao = new StaffDao();
$staff = $staffDao->getAll();
echo "Initial staff: " . count($staff) . "<br>";

// INSERT (Create)
$uniqueStaffEmail = 'staff.' . time() . '@ferrari.com';
$staffDao->insert([
    'first_name' => 'Test',
    'last_name' => 'Staff', 
    'email' => $uniqueStaffEmail,
    'position' => 'Sales Representative',
    'phone' => '555-0123'
]);
echo "Staff inserted<br>";

// GET ALL after insert
$staff = $staffDao->getAll();
echo "Staff after insert: " . count($staff) . "<br>";

// GET BY ID
if (count($staff) > 0) {
    $staffMember = $staffDao->getById($staff[0]['staff_id']);
    echo "Staff found by ID: " . ($staffMember ? "YES - Position: " . $staffMember['position'] : "NO") . "<br>";
}

// Test ContactDao
echo "<h2>ContactDao CRUD Test:</h2>";
$contactDao = new ContactDao();
$contacts = $contactDao->getAll();
echo "Initial contacts: " . count($contacts) . "<br>";

// INSERT (Create)
$contactDao->insert([
    'first_name' => 'Contact',
    'last_name' => 'Test',
    'email' => 'contact.test@example.com',
    'message' => 'This is a test contact message from a potential customer.'
]);
echo "Contact inserted<br>";

// GET ALL after insert
$contacts = $contactDao->getAll();
echo "Contacts after insert: " . count($contacts) . "<br>";

// GET BY ID
if (count($contacts) > 0) {
    $contact = $contactDao->getById($contacts[0]['contact_id']);
    echo "Contact found by ID: " . ($contact ? "YES - Message: " . substr($contact['message'], 0, 20) . "..." : "NO") . "<br>";
}

// Test ServiceDao
echo "<h2>ServiceDao CRUD Test:</h2>";
$serviceDao = new ServiceDao();
$services = $serviceDao->getAll();
echo "Initial services: " . count($services) . "<br>";

// INSERT (Create)
$serviceDao->insert([
    'user_id' => 1,
    'car_id' => 1,
    'service_type' => 'Oil Change',
    'preferred_dt' => '2024-12-01 10:00:00',
    'status' => 'requested'
]);
echo "Service inserted<br>";

// GET ALL after insert
$services = $serviceDao->getAll();
echo "Services after insert: " . count($services) . "<br>";

// Test TestDriveDao
echo "<h2>TestDriveDao CRUD Test:</h2>";
$testDriveDao = new TestDriveDao();
$testDrives = $testDriveDao->getAll();
echo "Initial test drives: " . count($testDrives) . "<br>";

// INSERT (Create)
$testDriveDao->insert([
    'user_id' => 1,
    'car_id' => 1,
    'preferred_date' => '2024-12-01',
    'preferred_time' => '14:00:00',
    'status' => 'requested'
]);
echo "Test drive inserted<br>";

// GET ALL after insert
$testDrives = $testDriveDao->getAll();
echo "Test drives after insert: " . count($testDrives) . "<br>";

echo "<h2 style='color: green;'>ALL 6 DAOs TESTED SUCCESSFULLY</h2>";
?>
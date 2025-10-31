<?php
require_once 'dao/UserDao.php';
require_once 'dao/CarDao.php';
require_once 'dao/StaffDao.php';
require_once 'dao/ContactDao.php';
require_once 'dao/ServiceDao.php';
require_once 'dao/TestDriveDao.php';

echo "<h1>Testing Ferrari Automotive Group DAOs</h1>";

try {
    // Test UserDao
    $userDao = new UserDao();
    echo "<h2>UserDao Test:</h2>";
    $users = $userDao->getAll();
    echo "Total users: " . count($users) . "<br>";

    // Test CarDao
    $carDao = new CarDao();
    echo "<h2>CarDao Test:</h2>";
    $cars = $carDao->getAll();
    echo "Total cars: " . count($cars) . "<br>";
    
    $availableCars = $carDao->getAvailableCars();
    echo "Available cars: " . count($availableCars) . "<br>";

    // Test StaffDao
    $staffDao = new StaffDao();
    echo "<h2>StaffDao Test:</h2>";
    $staff = $staffDao->getAll();
    echo "Total staff: " . count($staff) . "<br>";

    // Test ContactDao
    $contactDao = new ContactDao();
    echo "<h2>ContactDao Test:</h2>";
    $contacts = $contactDao->getAll();
    echo "Total contacts: " . count($contacts) . "<br>";

    // Test ServiceDao
    $serviceDao = new ServiceDao();
    echo "<h2>ServiceDao Test:</h2>";
    $services = $serviceDao->getAll();
    echo "Total services: " . count($services) . "<br>";

    // Test TestDriveDao
    $testDriveDao = new TestDriveDao();
    echo "<h2>TestDriveDao Test:</h2>";
    $testDrives = $testDriveDao->getAll();
    echo "Total test drives: " . count($testDrives) . "<br>";

    echo "<h2 style='color: green;'>All DAOs working correctly!</h2>";

} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error: " . $e->getMessage() . "</h2>";
}
?>
<?php
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/dao/CarDao.php';
require_once __DIR__ . '/dao/StaffDao.php';
require_once __DIR__ . '/dao/ContactDao.php';
require_once __DIR__ . '/dao/ServiceDao.php';
require_once __DIR__ . '/dao/TestDriveDao.php';

echo "=== Simple DAO Test (Like Classmates) ===\n\n";

$userDao = new UserDao();
$carDao = new CarDao();
$staffDao = new StaffDao();

echo "USERS:\n";
print_r($userDao->getAll());

echo "\nCARS:\n";
print_r($carDao->getAll());

echo "\nSTAFF:\n";
print_r($staffDao->getAll());

echo "\nAVAILABLE CARS:\n";
print_r($carDao->getAvailableCars());
?>
<?php
require_once __DIR__ . '/rest/dao/UserDao.php';
require_once __DIR__ . '/rest/dao/CarDao.php';
require_once __DIR__ . '/rest/dao/StaffDao.php';
require_once __DIR__ . '/rest/dao/ContactDao.php';
require_once __DIR__ . '/rest/dao/ServiceDao.php';
require_once __DIR__ . '/rest/dao/TestDriveDao.php';

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
<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CarDao.php';

class CarService extends BaseService {

    public function __construct() {
        parent::__construct(new CarDao());
    }

    // Business logic: Create a new car with validation
    public function create($data) {
        // Price validation
        if ($data['price'] < 100000) {
            throw new Exception('Ferrari cars cannot cost less than $100,000!');
        }

        // Year validation
        $currentYear = date('Y');
        if ($data['year'] < 1990 || $data['year'] > $currentYear + 1) {
            throw new Exception('Car year must be between 1990 and ' . ($currentYear + 1));
        }

        return parent::create($data);
    }

    // Optional: custom method for available cars
    public function getAvailableCars() {
        return $this->dao->getAvailableCars();
    }
}
?>

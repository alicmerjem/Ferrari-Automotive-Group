<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CarDao.php';

class CarService extends BaseService {
    public function __construct() {
        parent::__construct(new CarDao());
    }

    // Business logic: Ferrari validation
    public function create($data) {
        // Validation: Price must be realistic for a Ferrari
        if ($data['price'] < 100000) {
            throw new Exception('Ferrari cars cannot cost less than $100,000!');
        }
        
        // Validation: Year must be reasonable
        $currentYear = date('Y');
        if ($data['year'] < 1990 || $data['year'] > $currentYear + 1) {
            throw new Exception('Car year must be between 1990 and ' . ($currentYear + 1));
        }
        
        return parent::create($data);
    }

    // Custom business method
    public function getAvailableCars() {
        return $this->dao->getAvailableCars();
    }
}
?>
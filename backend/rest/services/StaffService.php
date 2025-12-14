<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/StaffDao.php';

class StaffService extends BaseService {
    public function __construct() {
        parent::__construct(new StaffDao());
    }

    // Business logic: Get staff members by position
    public function getByPosition($position) {
        return $this->dao->getByPosition($position);
    }
}
?>

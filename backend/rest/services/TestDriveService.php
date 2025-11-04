<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/TestDriveDao.php';

class TestDriveService extends BaseService {
    public function __construct() {
        parent::__construct(new TestDriveDao());
    }

    public function getByStatus($status) {
        return $this->dao->getByStatus($status);
    }
}
?>
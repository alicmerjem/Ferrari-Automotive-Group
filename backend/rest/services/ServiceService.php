<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ServiceDao.php';

class ServiceService extends BaseService {
    public function __construct() {
        parent::__construct(new ServiceDao());
    }

    public function getByStatus($status) {
        return $this->dao->getByStatus($status);
    }
}
?>
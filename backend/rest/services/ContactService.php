<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ContactDao.php';

class ContactService extends BaseService {
    public function __construct() {
        parent::__construct(new ContactDao());
    }

    // Business logic: Validate contact message
    public function create($data) {
        if (empty($data['message'])) {
            throw new Exception('Message cannot be empty');
        }

        return parent::create($data);
    }
}
?>

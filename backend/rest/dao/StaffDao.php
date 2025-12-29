<?php
require_once 'BaseDao.php';

class StaffDao extends BaseDao {
    public function __construct() {
        parent::__construct("staff", "staff_id");
    }

    public function getByPosition($position) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE position = :position";
        return $this->query($query, ['position' => $position])->fetchAll();
    }

    public function searchByName($name) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE first_name LIKE :name OR last_name LIKE :name";
        $searchName = "%" . $name . "%";
        return $this->query($query, ['name' => $searchName])->fetchAll();
    }
}
?>

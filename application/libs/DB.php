<?php


class DB {

    protected $db;

    public function __construct() {
        $this->db = new PDO(DBTYPE);
    }

} 
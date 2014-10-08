<?php


class Model extends PDO {

    protected $db;

    public function __construct() {
        $this->db = parent::__construct(DBTYPE);
    }

    public function login() {

    }

    public function logout() {

    }

} 
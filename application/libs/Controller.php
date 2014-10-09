<?php


class Controller {


    public function __construct() {
        Session::init();

        // user has remember-me-cookie ? then try to login with cookie ("remember me" feature)
        if (!isset($_SESSION['user_logged_in']) && isset($_COOKIE['rememberme'])) {
            header('location: ' . URL . 'login/loginWithCookie');
        }

//        jehaby-notes: why database connection in controller. Try no do it in model.
//        // create database connection
//        try {
//            $this->db = new Database();
//        } catch (PDOException $e) {
//            die('Database connection could not be established.');
//        }

        // create a view object (that does nothing, but provides the view render() method)
        $this->view = new View();
    }

    public function login() {

    }

    public function logout() {

    }

} 
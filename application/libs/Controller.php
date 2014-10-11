<?php


class Controller {


    public function __construct() {
        Session::init();

        // user has remember-me-cookie ? then try to login with cookie ("remember me" feature)
//        if (!isset($_SESSION['user_logged_in']) && isset($_COOKIE['rememberme'])) {
//            header('location: ' . URL . 'login/loginWithCookie');
//        }

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

    public function loadModel($name) {
        $path = MODELS_PATH . $name . 'Model.php';

        if (file_exists($path)) {
            require $path;
            // The "Model" has a capital letter as this is the second part of the model class name,
            // all models have names like "LoginModel"
            $modelName = $name . 'Model';
            // return the new model object while passing the database connection to the model
            return new $modelName();
        }
    }


} 
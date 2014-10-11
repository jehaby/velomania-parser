<?php


class Login extends Controller{

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        // create a login model to perform the getFacebookLoginUrl() method
//        $login_model = $this->loadModel('Login');

        // show the view
        $this->view->render('login/index');
    }

    public function login()
    {
        // run the login() method in the login-model, put the result in $login_successful (true or false)
        $login_model = $this->loadModel('Login');
        // perform the login method, put result (true or false) into $login_successful
        $login_successful = $login_model->login();

        // check login status
        if ($login_successful) {
            // if YES, then move user to dashboard/index (btw this is a browser-redirection, not a rendered view!)
            header('location: ' . URL . '/patterns');
        } else {
            // if NO, then move user to login/index (login form) again
            header('location: ' . URL . 'login/index');
        }
    }

    function register() {
        $this->view->render('login/register');
    }

    /**
     * Register page action (after form submit)
     */
    function register_action()
    {
        $login_model = $this->loadModel('Login');
        $registration_successful = $login_model->register();

        if ($registration_successful == true) {
            header('location: ' . URL . 'login/index');
        } else {
            header('location: ' . URL . 'login/register');
        }
    }


    public function logout()
    {
        $login_model = $this->loadModel('Login');
        $login_model->logout();
        // redirect user to base URL
        header('location: ' . URL);
    }


    public function resetPassword() {

    }


} 
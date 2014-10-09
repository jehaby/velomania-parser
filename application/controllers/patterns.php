<?php


class Patterns extends Controller {

    public function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }

    public function index() {
        $this->view->render('patterns/patterns');
    }

} 
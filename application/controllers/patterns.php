<?php


class Patterns extends Controller {

    public function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        $patterns_model = $this->loadModel('Patterns');
        $this->view->patterns = $patterns_model->getListOfPatterns();
        $this->view->render('patterns/patterns');
    }

    public function add() {

    }

    public function delete() {

    }

} 
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
        $patterns_model = $this->loadModel('Patterns');
        $themes_model = $this->loadModel("Themes");
        $patterns_model->add($themes_model);
        header('location: ' . URL . 'patterns');
    }

    public function delete() {
        $patterns_model = $this->loadModel('Patterns');
        $patterns_model->delete();
        header('location: ' . URL . 'patterns');
    }

} 
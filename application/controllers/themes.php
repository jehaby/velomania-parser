<?php


class Themes extends Controller {

    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    public function show($pattern_id)
    {
        $pattern_id = (int) $pattern_id;

        $themes_model = $this->loadModel('Themes');
        $this->view->themes = $themes_model->getThemes($pattern_id);
        $this->view->render('themes/themes.php');
    }


} 
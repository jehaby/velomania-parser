<?php


class Themes extends Controller {

    public function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }


} 
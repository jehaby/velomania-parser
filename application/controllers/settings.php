<?php


class Settings extends Controller{

    public function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }


} 
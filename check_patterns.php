<?php

require 'application/configs/config.php';
require 'application/configs/private_config.php';
require 'application/configs/autoloader.php';

if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

require 'application/models/ThemesModel.php';

$themes_model = new ThemesModel();
$themes_model->checkAllPatterns();

 
<?php

//$path =  realpath(dirname(__FILE__));

//require $path . '/application/configs/config.php';
//require $path . '/application/configs/private_config.php';
//require $path . '/application/configs/autoloader.php';
//
//if (file_exists($path . '/vendor/autoload.php')) {
//    require $path . '/vendor/autoload.php';
//}
//
//require $path . '/application/models/ThemesModel.php';

chdir(realpath(dirname(__FILE__)));

require 'application/configs/config.php';
require 'application/configs/private_config.php';
require 'application/configs/autoloader.php';

if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

require 'application/models/ThemesModel.php';

$themes_model = new ThemesModel();
$themes_model->checkAllPatterns();

 
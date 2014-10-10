<?php

require 'application/configs/config.php';
require 'application/configs/autoloader.php';

if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

$app = new Application();
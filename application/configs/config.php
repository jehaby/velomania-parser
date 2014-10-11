<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


// 1209600 seconds = 2 weeks
define('COOKIE_RUNTIME', 1209600);
// the domain where the cookie is valid for, for local development ".127.0.0.1" and ".localhost" will work
// IMPORTANT: always put a dot in front of the domain, like ".mydomain.com" !
define('COOKIE_DOMAIN', '.localhost');


/**
 * Configuration for: Base URL
 * This is the base url of our app. if you go live with your app, put your full domain name here.
 * if you are using a (different) port, then put this in here, like http://mydomain:8888/subfolder/
 * Note: The trailing slash is important!
 */
define('URL', 'http://localhost/projects/velomania-parser/');

define('DBTYPE', 'sqlite:/opt/lampp/htdocs/projects/velomania-parser/db.db');  // TODO: do it better

define('LIBS_PATH', 'application/libs/');
define('CONTROLLER_PATH', 'application/controllers/');
define('MODELS_PATH', 'application/models/');
define('VIEWS_PATH', 'application/views/');

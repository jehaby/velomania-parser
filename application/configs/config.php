<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


// 1209600 seconds = 2 weeks
define('COOKIE_RUNTIME', 1209600);
// the domain where the cookie is valid for, for local development ".127.0.0.1" and ".localhost" will work
// IMPORTANT: always put a dot in front of the domain, like ".mydomain.com" !
define('COOKIE_DOMAIN', '.localhost');

define('SECRET_CODE', 'green');
/**
 * Configuration for: Base URL
 * This is the base url of our app. if you go live with your app, put your full domain name here.
 * if you are using a (different) port, then put this in here, like http://mydomain:8888/subfolder/
 * Note: The trailing slash is important!
 */
define('URL', 'http://localhost/projects/velomania-parser/');

define('DBTYPE', 'sqlite:/opt/lampp/htdocs/projects/velomania-parser/public/db/db.db');  // TODO: do it better

define('LIBS_PATH', 'application/libs/');
define('CONTROLLER_PATH', 'application/controllers/');
define('MODELS_PATH', 'application/models/');
define('VIEWS_PATH', 'application/views/');

define("FEEDBACK_UNKNOWN_ERROR", "Unknown error occurred!");
define("FEEDBACK_PASSWORD_WRONG_3_TIMES", "You have typed in a wrong password 3 or more times already. Please wait 30 seconds to try again.");
define("FEEDBACK_LOGIN_FAILED", "Login failed.");
define("FEEDBACK_USERNAME_FIELD_EMPTY", "Username field was empty.");
define("FEEDBACK_PASSWORD_FIELD_EMPTY", "Password field was empty.");
define("FEEDBACK_EMAIL_FIELD_EMPTY", "Email and passwords fields were empty.");
define("FEEDBACK_EMAIL_AND_PASSWORD_FIELDS_EMPTY", "Email field was empty.");
define("FEEDBACK_USERNAME_SAME_AS_OLD_ONE", "Sorry, that username is the same as your current one. Please choose another one.");
define("FEEDBACK_USERNAME_ALREADY_TAKEN", "Sorry, that username is already taken. Please choose another one.");
define("FEEDBACK_USER_EMAIL_ALREADY_TAKEN", "Sorry, that email is already in use. Please choose another one.");
define("FEEDBACK_USERNAME_CHANGE_SUCCESSFUL", "Your username has been changed successfully.");
define("FEEDBACK_USERNAME_AND_PASSWORD_FIELD_EMPTY", "Username and password fields were empty.");
define("FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN", "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters.");
define("FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN", "Sorry, your chosen email does not fit into the email naming pattern.");
define("FEEDBACK_EMAIL_SAME_AS_OLD_ONE", "Sorry, that email address is the same as your current one. Please choose another one.");
define("FEEDBACK_EMAIL_CHANGE_SUCCESSFUL", "Your email address has been changed successfully.");
define("FEEDBACK_CAPTCHA_WRONG", "The entered captcha security characters were wrong.");
define("FEEDBACK_PASSWORD_REPEAT_WRONG", "Password and password repeat are not the same.");
define("FEEDBACK_PASSWORD_TOO_SHORT", "Password has a minimum length of 6 characters.");
define("FEEDBACK_USERNAME_TOO_SHORT_OR_TOO_LONG", "Username cannot be shorter than 2 or longer than 64 characters.");
define("FEEDBACK_EMAIL_TOO_LONG", "Email cannot be longer than 64 characters.");
define("FEEDBACK_ACCOUNT_SUCCESSFULLY_CREATED", "Your account has been created successfully");
define("FEEDBACK_WRONG_SECRET_CODE", "You entered wrong secret code");
define('FEEDBACK_PASSWORD_WRONG', 'Wrong username or password');

define('FEEDBACK_PATTERN_NO_PATTERN_OR_SECTIONS', 'You have to choose at least one section');
define('FEEDBACK_PATTERN_USER_ALREADY_HAS_PATTERN', 'You already have this pattern with same sections');


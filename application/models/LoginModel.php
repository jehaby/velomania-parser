<?php


class LoginModel extends Model{


    public function login()
    {
        // we do negative-first checks here
        if (!isset($_POST['user_name']) OR empty($_POST['user_name'])) {
            $_SESSION["feedback_negative"][] = FEEDBACK_USERNAME_FIELD_EMPTY;
            return false;
        }
        if (!isset($_POST['user_password']) OR empty($_POST['user_password'])) {
            $_SESSION["feedback_negative"][] = FEEDBACK_PASSWORD_FIELD_EMPTY;
            return false;
        }

        // get user's data
        // (we check if the password fits the password_hash via password_verify() some lines below)
//        $sth = $this->db->prepare("SELECT user_id,
//                                          user_name,
//                                          user_email,
//                                          user_password,
//                                          user_failed_logins,
//                                          user_last_failed_login
//                                   FROM   User
//                                   WHERE  user_name = 'urf'");


        $sth = $this->db->prepare("SELECT user_id,
                                          user_name,
                                          user_email,
                                          user_password,
                                          user_failed_logins,
                                          user_last_failed_login
                                   FROM   User
                                   WHERE  user_name = :user_name;");

        $sth->execute(array(":user_name" => $_POST['user_name']));

//        $count =  $sth->rowCount();  don't work with sqlite?
//        // if there's NOT one result
//        if ($count != 1) {
//            // was FEEDBACK_USER_DOES_NOT_EXIST before, but has changed to FEEDBACK_LOGIN_FAILED
//            // to prevent potential attackers showing if the user exists
//            $_SESSION["feedback_negative"][] = FEEDBACK_LOGIN_FAILED;
//            return false;
//        }

        // fetch one row (we only have one result)
        $result = $sth->fetch(PDO::FETCH_OBJ);
//        d($result);

        // block login attempt if somebody has already failed 3 times and the last login attempt is less than 30sec ago
        if (($result->user_failed_logins >= 3) AND ($result->user_last_failed_login > (time()-30))) {
            $_SESSION["feedback_negative"][] = FEEDBACK_PASSWORD_WRONG_3_TIMES;
            return false;
        }

        // check if hash of provided password matches the hash in the database
        if (password_verify($_POST['user_password'], $result->user_password)) {  // TODO: use normal password_verify

            // login process, write the user data into session
            Session::init();
            Session::set('user_logged_in', true);
            Session::set('user_id', $result->user_id);
            Session::set('user_name', $result->user_name);
            Session::set('user_email', $result->user_email);

            // reset the failed login counter for that user (if necessary)
            if ($result->user_last_failed_login > 0) {
                $sql = "UPDATE User SET user_failed_logins = 0, user_last_failed_login = NULL
                        WHERE user_id = :user_id AND user_failed_logins != 0";
                $sth = $this->db->prepare($sql);
                $sth->execute(array(':user_id' => $result->user_id));
            }

            // generate integer-timestamp for saving of last-login date
            $user_last_login_timestamp = time();
            // write timestamp of this login into database (we only write "real" logins via login form into the
            // database, not the session-login on every page request
            $sql = "UPDATE User SET user_last_login_timestamp = :user_last_login_timestamp WHERE user_id = :user_id";
            $sth = $this->db->prepare($sql);
            $sth->execute(array(':user_id' => $result->user_id, ':user_last_login_timestamp' => $user_last_login_timestamp));

            // if user has checked the "remember me" checkbox, then write cookie
            if (isset($_POST['user_rememberme'])) {

                // generate 64 char random string
                $random_token_string = hash('sha256', mt_rand());

                // write that token into database
                $sql = "UPDATE User SET user_rememberme_token = :user_rememberme_token WHERE user_id = :user_id";
                $sth = $this->db->prepare($sql);
                $sth->execute(array(':user_rememberme_token' => $random_token_string, ':user_id' => $result->user_id));

                // generate cookie string that consists of user id, random string and combined hash of both
                $cookie_string_first_part = $result->user_id . ':' . $random_token_string;
                $cookie_string_hash = hash('sha256', $cookie_string_first_part);
                $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;

                // set cookie
                setcookie('rememberme', $cookie_string, time() + COOKIE_RUNTIME, "/", COOKIE_DOMAIN);
            }

            // return true to make clear the login was successful
            return true;

        } else {
            // increment the failed login counter for that user
            $sql = "UPDATE User
                    SET user_failed_logins = user_failed_logins+1, user_last_failed_login = :user_last_failed_login
                    WHERE user_name = :user_name";
            $sth = $this->db->prepare($sql);
            $sth->execute(array(':user_name' => $_POST['user_name'], ':user_last_failed_login' => time() ));
            // feedback message
            $_SESSION["feedback_negative"][] = FEEDBACK_PASSWORD_WRONG;
            return false;
        }

        // default return
        return false;
    }

    public function logout()
    {
        // set the remember-me-cookie to ten years ago (3600sec * 365 days * 10).
        // that's obviously the best practice to kill a cookie via php
        // @see http://stackoverflow.com/a/686166/1114320
        setcookie('rememberme', false, time() - (3600 * 3650), '/', COOKIE_DOMAIN);

        // delete the session
        Session::destroy();
    }

    public function register() {
        if (empty($_POST['user_name'])) {
            $_SESSION["feedback_negative"][] = FEEDBACK_USERNAME_FIELD_EMPTY;
        } elseif (empty($_POST['user_password_new']) OR empty($_POST['user_password_repeat'])) {
            $_SESSION["feedback_negative"][] = FEEDBACK_PASSWORD_FIELD_EMPTY;
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $_SESSION["feedback_negative"][] = FEEDBACK_PASSWORD_REPEAT_WRONG;
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $_SESSION["feedback_negative"][] = FEEDBACK_PASSWORD_TOO_SHORT;
        } elseif (strlen($_POST['user_name']) > 64 OR strlen($_POST['user_name']) < 2) {
            $_SESSION["feedback_negative"][] = FEEDBACK_USERNAME_TOO_SHORT_OR_TOO_LONG;
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $_SESSION["feedback_negative"][] = FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN;
        } elseif (empty($_POST['user_email'])) {
            $_SESSION["feedback_negative"][] = FEEDBACK_EMAIL_FIELD_EMPTY;
        } elseif (strlen($_POST['user_email']) > 64) {
            $_SESSION["feedback_negative"][] = FEEDBACK_EMAIL_TOO_LONG;
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {   // TODO: WATCH AND LEARN
            $_SESSION["feedback_negative"][] = FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN;
        } elseif ($_POST['secret_code'] != SECRET_CODE) {
            $_SESSION["feedback_negative"][] = FEEDBACK_WRONG_SECRET_CODE;
        } elseif (!empty($_POST['user_name'])
            AND strlen($_POST['user_name']) <= 64
            AND strlen($_POST['user_name']) >= 2
            AND preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            AND !empty($_POST['user_email'])
            AND strlen($_POST['user_email']) <= 64
            AND filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            AND !empty($_POST['user_password_new'])
            AND !empty($_POST['user_password_repeat'])
            AND ($_POST['user_password_new'] === $_POST['user_password_repeat'])) {

            // clean the input
            $user_name = strip_tags($_POST['user_name']);  // TODO: think, should it be earlier?
            $user_email = strip_tags($_POST['user_email']);

            // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character
            // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4,
            // by the password hashing compatibility library. the third parameter looks a little bit shitty, but that's
            // how those PHP 5.5 functions want the parameter: as an array with, currently only used with 'cost' => XX

            $user_password_hash = password_hash($_POST['user_password_new'], PASSWORD_DEFAULT);

            // check if username already exists
            $query = $this->db->prepare("SELECT * FROM User WHERE user_name = :user_name");
            $query->execute(array(':user_name' => $user_name));
            if ($query->fetch()) {
                $_SESSION["feedback_negative"][] = FEEDBACK_USERNAME_ALREADY_TAKEN;
                return false;
            }

            // check if email already exists
            $query = $this->db->prepare("SELECT user_id FROM User WHERE user_email = :user_email");
            $query->execute(array(':user_email' => $user_email));
            if ($query->fetch()) {
                $_SESSION["feedback_negative"][] = FEEDBACK_USER_EMAIL_ALREADY_TAKEN;
                return false;
            }

            // generate integer-timestamp for saving of account-creating date
            $user_creation_timestamp = time();

            // write new users data into database
            $sql = "INSERT INTO User (user_name, user_password, user_email, user_creation_timestamp)
                    VALUES (:user_name, :user_password, :user_email, :user_creation_timestamp)";
            $query = $this->db->prepare($sql);
            $query_result = $query->execute(array(':user_name' => $user_name,
                ':user_password' => $user_password_hash,
                ':user_email' => $user_email,
                ':user_creation_timestamp' => $user_creation_timestamp));

            if (!$query_result) {
                $_SESSION["feedback_negative"][] = FEEDBACK_ACCOUNT_CREATION_FAILED;
                return false;
            }

            // get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
            $query = $this->db->prepare("SELECT user_id FROM User WHERE user_name = :user_name");
            $query_result = $query->execute(array(':user_name' => $user_name));
            if (!$query_result) {
                $_SESSION["feedback_negative"][] = FEEDBACK_UNKNOWN_ERROR;
                return false;
            }
            $result_user_row = $query->fetch(PDO::FETCH_OBJ);
            $user_id = $result_user_row->user_id;

            $_SESSION["feedback_positive"][] = FEEDBACK_ACCOUNT_SUCCESSFULLY_CREATED;
            return true;
        } else {
            $_SESSION["feedback_negative"][] = FEEDBACK_UNKNOWN_ERROR;
        }
// default return, returns only true of really successful (see above)
        return false;
    }
    private function password_verify($p1, $p1) {
        return true;
    }

} 
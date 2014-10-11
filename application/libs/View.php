<?php


class View {

    public function render($filename) {
        require VIEWS_PATH . 'templates/header.php';
        require VIEWS_PATH . 'templates/auth.php';
        require VIEWS_PATH . $filename . '.php';
        require VIEWS_PATH . 'templates/footer.php';
    }

    public function renderFeedbackMessages()
    {
        // echo out the feedback messages (errors and success messages etc.),
        // they are in $_SESSION["feedback_positive"] and $_SESSION["feedback_negative"]
        require VIEWS_PATH . 'templates/feedback.php';

        // delete these messages (as they are not needed anymore and we want to avoid to show them twice
        Session::set('feedback_positive', null);
        Session::set('feedback_negative', null);
    }


} 
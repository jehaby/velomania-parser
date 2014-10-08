<?php


class View {

    public function render($filename) {
        require VIEWS_PATH . 'templates/header.php';
        require VIEWS_PATH . $filename . '.php';
        require VIEWS_PATH . 'templates/footer.php';
    }

} 
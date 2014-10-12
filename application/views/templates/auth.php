<div id="auth">
    <p>-------------------------</p>
    <?php
    Session::init();
    if (isset($_SESSION['user_logged_in'])) {
        echo "<p> Hello, {$_SESSION['user_name']}! </p>";
        echo sprintf("<p><a href='%slogin/logout'>Выйти</a> </p>", URL);
    } else {
        echo "<p> You have to <a href='" . URL ."login'>log in</a> or " .
            "<a href='" . URL . "login/register'>register</a> to use this site. </p>";
    }
    ?>
    <p>-------------------------</p>
</div>
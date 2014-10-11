<div class="content">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <div class="register-default-box">
        <h1>Register</h1>
        <!-- register form -->
        <form method="post" action="<?php echo URL; ?>login/register_action" name="registerform">
            <div>
                <!-- the user name input field uses a HTML5 pattern check -->
                <label for="login_input_username">
                    Username
                    <span style="display: block; font-size: 14px; color: #999;">(only letters and numbers, 2 to 64 characters)</span>
                </label>
                <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
                <!-- the email input field uses a HTML5 email type check -->
            </div>
            <div>
                <label for="login_input_email">
                    User's email
                <span style="display: block; font-size: 14px; color: #999;">
                    (please provide a <span style="text-decoration: underline; color: mediumvioletred;">real email address</span>,
                    you'll get a verification mail with an activation link)
                </span>
                </label>
                <input id="login_input_email" class="login_input" type="email" name="user_email" required />
            </div>
            <div>
                <label for="login_input_password_new">
                    Password (min. 6 characters!
                <span class="login-form-password-pattern-reminder">
                    Please note: using a long sentence as a password is much much safer then something like "!c00lPa$$w0rd").
                    Have a look on
                    <a href="http://security.stackexchange.com/questions/6095/xkcd-936-short-complex-password-or-long-dictionary-passphrase">
                        this interesting security.stackoverflow.com thread
                    </a>.
                </span>
                </label>
                <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
                <label for="login_input_password_repeat">Repeat password</label>
                <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
            </div>
            <div>
                <label for="login_input_secret_code">Secret code</label>
                <input id="login_input_secret_code" type="text" required name="secret_code"/>
            </div>

            <input type="submit"  name="register" value="Register" />

        </form>
    </div>

</div>

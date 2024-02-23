

<div id="opacity">
    <div class="main">
        <div class="login-header">
            <h3>Přihlášení</h3>
        </div>

        <div class="container login-form">

            <div class="login-area">
                <form method="POST" class="" name="authorization">
                    <?php //action="user/authorization"?>
                    <div class="name-container">
                        <label for="userEmail" class="label_text">Email*</label>
                        <input type="text" name="userEmail" id="userEmail" class="field-1" maxlength="75">
                    </div>
                    <div class="password-container">
                        <label for="userPassword" class="label_text">Heslo*</label>
                        <input type="password" name="userPassword" id="userPassword" class="field-1" maxlength="75">
                    </div>
                    <div class="login-checkbox-container">
                        <div class="login-checkbox-wrapper">
                            <input type="checkbox" class="stay-in-account-checkbox" name="remember_me">
                        </div>
                        <div class="login-checkbox-text">
                            <span class="stay-in-account">Zůstat přihlášen</span>
                        </div>
                    </div>

                    <div class="forgot-password-container">
                        <a href="user/password-reset" class="forgot-password">Zapomněl jsem heslo</a>
                    </div>

                    <div class="register-account">
                        <a href="user/signup" class="forgot-password">Chci se registrovat</a>
                    </div>

                    <div class="errors_field user_errors_field"></div>


                    <div class="submit-container">
                        <input type="submit" class="submit_button" id="contact-submit" value="Přihlásit se">
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
<div style="display: none" class="loader-wrapper">
    <div class="loader"></div>
</div>
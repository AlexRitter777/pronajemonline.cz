<div id="opacity">
    <div class="main">
        <div class="login-header">
            <h3>Zapomenuté heslo</h3>
        </div>

        <div class="container login-form">

            <div class="login-area">
                <form method="POST" class="" name="changepassword">
                    <?php //action="user/change-password"?>
                    <div class="password-container">
                        <label for="login_password" class="label_text">Heslo *</label>
                        <input type="password" name="userPassword" id="userPassword" class="field-1" maxlength="75">
                    </div>
                    <div class="password-container">
                        <label for="login_password_repeat" class="label_text">Heslo ještě jednou *</label>
                        <input type="password" name="userPasswordRepeat" id="userPasswordRepeat" class="field-1" maxlength="75">
                    </div>


                    <div class="errors_field user_errors_field"></div>


                    <div class="submit-container">
                        <input type="submit" class="submit_button" id="contact-submit" value="Odeslat">
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
<div style="display: none" class="loader-wrapper">
    <div class="loader"></div>
</div>


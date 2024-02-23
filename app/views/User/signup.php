

<div id="opacity">
    <div class="main">
        <div class="login-header">
            <h3>Registrace</h3>
        </div>

        <div class="container login-form">

            <div class="login-area">
                <form method="POST" class="" name="register">
                    <?php //action="user/register"?>
                    <div class="name-container">
                        <label for="userName" class="label_text">Jméno *</label>
                        <input type="text" name="userName" id="userName" class="field-1" maxlength="75">
                    </div>

                    <div class="name-container">
                        <label for="userEmail" class="label_text">E-mail *</label>
                        <input type="email" name="userEmail" id="userEmail" class="field-1" maxlength="75">
                    </div>
                    <div class="error-user"></div>
                    <div class="password-container">
                        <label for="userPassword" class="label_text">Heslo *</label>
                        <input type="password" name="userPassword" id="userPassword" class="field-1" maxlength="75">
                    </div>
                    <div class="password-container">
                        <label for="userPasswordRepeat" class="label_text">Heslo ještě jednou *</label>
                        <input type="password" name="userPasswordRepeat" id="userPasswordRepeat" class="field-1" maxlength="75">
                    </div>


                    <div class="errors_field user_errors_field"></div>


                    <div class="submit-container">
                        <input type="submit" class="submit_button" id="signup-submit" value="Registrovat se">
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
<div style="display: none" class="loader-wrapper">
    <div class="loader"></div>
</div>

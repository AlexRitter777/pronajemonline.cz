

<div id="opacity">
    <div class="main">
        <div class="login-header">
            <h3>Zapomenuté heslo</h3>
        </div>

        <div class="container login-form">

            <div class="login-area">
                <form method="POST" class="" name="sendresetlink">
                    <?php //action="user/send-reset-link"?>
                    <div class="name-container">
                        <label for="userEmail" class="label_text forgot_label_text">Email, zadány při registraci *</label>
                        <input type="text" name="userEmail" id="userEmail" class="field-1" maxlength="75">
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

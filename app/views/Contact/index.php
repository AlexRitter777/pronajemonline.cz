

<div id="opacity">
    <div class="main">
        <div class="contact-header">
            <h3>Kontakt</h3>
        </div>


        <div class="container contact-form">
            <!--<h3 class="contact-title">Kontakt</h3>-->

            <div class="contact-area">
                <form method="POST" class="form" name="contact">
                    <div class="name_container">
                        <label for="contactName" class="label_text">Jméno*</label>
                        <input type="text" name="contactName" id="contactName" class="field-1" maxlength="75">
                    </div>
                    <div class="email-container">
                        <label for="contactEmail" class="label_text">E-mail*</label>
                        <input type="text" name="contactEmail" id="contactEmail" class="field-1" maxlength="75">
                    </div>
                    <div class="message-container">
                        <label for="contactMessage" class="label_text">Zpráva*</label>
                        <textarea  name="contactMessage" id="contactMessage" class="field-1 text-message" maxlength="1000"></textarea>
                    </div>
                    <div class="errors_field"></div>

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
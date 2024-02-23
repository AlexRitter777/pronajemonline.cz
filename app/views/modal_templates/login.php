<!--Login modal window template-->

<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Přihlášení</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form login-modal' name="modal-login" data-type="modal">
            <table class="tenants-modal login-calculation" border="0">

                <tr class="row-1">
                    <td class="col-1">Email*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="userEmail" data-lang="E-mail uživatele"></td>
                </tr>

                <tr class="row-2">
                    <td class="col-1">Heslo*</td>
                    <td class="col-2">
                        <input type="password" class="input-profile input-profile-modal" name="" id="userPassword" data-lang="Heslo uživatele">
                    </td>
                </tr>

                <tr class="row-3">
                    <td class="col-1" colspan="2">
                        <input type="checkbox" class="stay-in-account-checkbox" id="remember_me" name="remember_me">
                        <label for="remember_me" class="stay-in-account-modal">Zůstat přihlášen</label>
                    </td>
                </tr>

                <tr class="row-4">
                    <td class="col-1" colspan="2"><a href="user/password-reset" class="forgot-password" target="_blank">Zapomněl jsem heslo</a></td>

                </tr>

                <tr class="row-5" >
                    <td class="col-1" colspan="2"><a href="user/signup" class="forgot-password">Chci se registrovat</a></td>
                </tr>



            </table>

            <div class="errors_field user_errors_field modal_errors_field"></div>

            <div class="modal_buttons">
                <input type="submit"  class="submit_button submit_button_modal modal-login" id="" value="Přihlásit se">
                <button type="button"  class="submit_button_refresh submit_button_refresh_modal">Zrušit</button>
            </div>
        </form>

        <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
            <div class="loader loader_modal"></div>
        </div>

    </div>

</div>

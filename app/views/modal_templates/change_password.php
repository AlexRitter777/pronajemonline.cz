<!--Login modal window template-->

<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Změna hesla</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form change-password-modal' name="change-password" data-type="modal">
            <table class="tenants-modal change-password-table" border="0">

                <tr class="row-1">
                    <td class="col-1">Stávající heslo*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="password" name="" id="password" data-lang="Stávající heslo"></td>
                </tr>

                <tr class="row-2">
                    <td class="col-1">Nové heslo*</td>
                    <td class="col-2">
                        <input type="password" class="input-profile input-profile-modal" name="" id="new_password" data-lang="Nové heslo">
                    </td>
                </tr>

                <tr class="row-3">
                    <td class="col-1">Nové heslo - po druhé*</td>
                    <td class="col-2">
                        <input type="password" class="input-profile input-profile-modal" name="" id="new_password_repeat" data-lang="Nové heslo po druhé">
                    </td>
                </tr>

            </table>

            <div class="errors_field user_errors_field modal_errors_field"></div>

            <div class="modal_buttons">
                <input type="submit"  class="submit_button submit_button_modal modal-change-password" id="" data-user_email="<?=$_SESSION['useremail'];?>" value="Uložit">
                <button type="button"  class="submit_button_refresh submit_button_refresh_modal">Zrušit</button>
            </div>
        </form>

        <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
            <div class="loader loader_modal"></div>
        </div>

    </div>

</div>


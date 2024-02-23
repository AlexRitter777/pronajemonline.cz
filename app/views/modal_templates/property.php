<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Nová nemovitost</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form' name="property" data-type="modal" action="">
            <table class="tenants-modal" border="0">

                <tr class="row-1">
                    <td class="col-1">Adresa*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="property_address" data-lang="Adresa nemovitosti"></td>
                </tr>
                <tr class="row-2">
                    <td class="col-1">Druh nemovitosti*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="property_type" data-lang="Druh nemovitosti"></td>
                </tr>
                <tr class="row-2">
                    <td colspan="2"><a href="/user/properties/add" id="new_property_full" target="_blank">Přidat více informaci o nemovitosti</a></td>

                </tr>
            </table>


            <div class="errors_field user_errors_field modal_errors_field"></div>

            <div class="modal_buttons">
                <input type="submit" class="submit_button submit_button_modal recaptcha" id="new-property" value="Uložit">
                <button type="button" class="submit_button_refresh submit_button_refresh_modal">Zrušit</button>
            </div>
        </form>

        <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
            <div class="loader loader_modal"></div>
        </div>

    </div>

</div>

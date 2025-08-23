<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Vyplňte údaje</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form' name="property" data-type="modal" action="">
            <table class="tenants-modal" border="0">

                <tr class="row-1">
                    <td class="col-1">Adresa*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="property_address" data-lang="Adresa nemovitosti"></td>
                </tr>
                <tr class="row-2">
                    <td class="col-1">Typ nemovitosti*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="property_type" data-lang="Typ nemovitosti"></td>
                </tr>
                <tr class="row-3 link-wrapper">
                    <td colspan="2"><a href="/user/properties/add" id="new_property_full" target="_blank">Přidat další informace o nemovitosti</a></td>

                </tr>
            </table>


            <div class="errors_field user_errors_field modal_errors_field"></div>

            <div class="modal_buttons">
                <input type="submit" class="form-btn btn-submit recaptcha" id="new-property" value="Uložit">
                <input type="button" class="form-btn btn-reset submit_button_refresh_modal" value="Zrušit">
            </div>

        </form>



    </div>

    <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
        <div class="loader loader_modal"></div>
    </div>

</div>

<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Nový pronajímatel</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form' name="landlord" data-type="modal" action="">
            <table class="tenants-modal" border="0">

                <tr class="row-1">
                    <td class="col-1">Jméno*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="landlord_name" data-lang="Jméno pronajímatele"></td>
                </tr>
                <tr class="">
                    <td class="col-1">Adresa*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="landlord_address" data-lang="Adresa pronajímatele"></td>
                </tr>

                <tr class="">
                    <td class="col-1">E-mail</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="landlord_email" data-lang="E-mail pronajímatele"></td>
                </tr>

                <tr class="">
                    <td class="col-1">Telefon</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="landlord_phone_number" data-lang="Telefonní číslo pronajímatele">
                    </td>
                </tr>


                <tr class="">
                    <td class="col-1">Číslo účtu</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="landlord_account" data-lang="Číslo účtu pronajímatele"></td>
                </tr>


            </table>

            <div class="errors_field user_errors_field modal_errors_field"></div>

            <div class="modal_buttons">
                <input type="submit" class="submit_button submit_button_modal recaptcha" id="" value="Uložit">
                <button type="button" class="submit_button_refresh submit_button_refresh_modal">Zrušit</button>
            </div>
        </form>

        <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
            <div class="loader loader_modal"></div>
        </div>

    </div>

</div>


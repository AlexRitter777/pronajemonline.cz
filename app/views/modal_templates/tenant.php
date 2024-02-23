<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Nový nájemník</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form' name="tenant" data-type="modal" action="">
            <table class="tenants-modal" border="0">

                <tr class="row-1">
                    <td class="col-1">Jméno*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="tenant_name" data-lang="Jméno nájemníka"></td>
                </tr>
                <tr class="">
                    <td class="col-1">Adresa*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="tenant_address" data-lang="Adresa nájemníka"></td>
                </tr>

                <tr class="">
                    <td class="col-1">E-mail</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="tenant_email" data-lang="E-mail nájemníka"></td>
                </tr>

                <tr class="">
                    <td class="col-1">Telefon</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="tenant_phone_number" data-lang="Telefonní číslo nájemníka">
                    </td>
                </tr>


                <tr class="">
                    <td class="col-1">Číslo účtu</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="tenant_account" data-lang="Číslo účtu nájemníka"></td>
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

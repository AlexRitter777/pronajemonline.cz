<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Nový správce</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form' name="admin" data-type="modal" action="">
            <table class="tenants-modal" border="0">

                <tr class="row-1">
                    <td class="col-1">Název*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="admin_name" data-lang="Název správce"></td>
                </tr>
                <tr class="">
                    <td class="col-1">Telefon</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="admin_phone" data-lang="Telefon správce"></td>
                </tr>

                <tr class="">
                    <td class="col-1">E-mail</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="admin_email" data-lang="E-mail správce"></td>
                </tr>


                <tr class="">
                    <td class="col-1">Technik</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="admin_tech_name" data-lang="Jméno technika">
                    </td>
                </tr>


                <tr class="">
                    <td class="col-1">Technik - telefon</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="admin_tech_phone" data-lang="Telefon technika">
                    </td>
                </tr>

                <tr class="">
                    <td class="col-1">Technik - email</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="admin_tech_email" data-lang="E-mail technika">
                    </td>
                </tr>


                <tr class="">
                    <td class="col-1">Účetní</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="admin_acc_name" data-lang="Jméno účetní">
                    </td>
                </tr>

                <tr class="">
                    <td class="col-1">Účetní - telefon</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="admin_acc_phone" data-lang="Telefon účetní">
                    </td>
                </tr>


                <tr class="">
                    <td class="col-1">Účetní - email</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="admin_acc_email" data-lang="E-mail účetní">
                    </td>
                </tr>


            </table>

            <div class="errors_field user_errors_field modal_errors_field"></div>

            <div class="modal_buttons">
                <input type="submit" class="submit_button submit_button_modal recaptcha" id="new-admin" value="Uložit">
                <button type="button" class="submit_button_refresh submit_button_refresh_modal">Zrušit</button>
            </div>
        </form>

        <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
            <div class="loader loader_modal"></div>
        </div>

    </div>

</div>
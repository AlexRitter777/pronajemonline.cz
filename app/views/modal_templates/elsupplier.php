<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Nový dodavatel elektřiny</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form' name="elsupplier" data-type="modal" action="">
            <table class="tenants-modal" border="0">

                <tr class="row-1">
                    <td class="col-1">Název*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" id="elsupplier_name" data-lang="Název dodavatele elektřiny"></td>
                </tr>
                <tr class="">
                    <td class="col-1">Informace</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="elsupplier_add_info" data-lang="Informace"></td>
                </tr>

            </table>

            <div class="errors_field user_errors_field modal_errors_field"></div>

            <div class="modal_buttons">
                <input type="submit" class="submit_button submit_button_modal recaptcha" id="new-elsupplier" value="Uložit">
                <button type="button" class="submit_button_refresh submit_button_refresh_modal">Zrušit</button>
            </div>
        </form>

        <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
            <div class="loader loader_modal"></div>
        </div>

    </div>

</div>
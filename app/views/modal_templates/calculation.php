<!--Save calculation modal window template-->

<div id="modal-opacity">

    <div class="user-header user-header-modal">
        <h3>Uložit kalkulaci</h3>
    </div>

    <div class="central-bar">
        <form method="post" class='modal_window_form' name="calculation" data-type="modal" action="">
            <table class="tenants-modal save-calculation" border="0">

                <tr class="row-1">
                    <td class="col-1">Název*</td>
                    <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="calculation_name" data-lang="Název kalkulaci"></td>
                </tr>

                <tr class="">
                    <td class="col-1">Popis</td>
                    <td class="col-2">
                        <textarea class="input-profile input-profile-modal" type="text" name="" id="calculation_description" data-lang="Popis kalkulaci"></textarea>
                    </td>
                </tr>

            </table>

            <div class="errors_field user_errors_field modal_errors_field"></div>

            <div class="modal_buttons">
                <input type="submit"  class="submit_button submit_button_modal save-calc" id="new-admin" value="Uložit">
                <button type="button"  class="submit_button_refresh submit_button_refresh_modal">Zrušit</button>
            </div>
        </form>

        <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
            <div class="loader loader_modal"></div>
        </div>

    </div>

</div>

<div class="user-header">
    <h3>Nový pronajímatel</h3>
</div>

<div class="table-container entity-table">

    <form method="post" name="landlord" class="" action="landlords/store" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">
                    <label for="landlord_name">Jméno*</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['landlord_name']) ? 'error_field_form' : '';?>"
                        type="text"
                        id="landlord_name"
                        name="landlord_name"
                        value="<?= $old['landlord_name'] ?? ''; ?>"
                        data-lang="Jméno pronajímatele"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="landlord_address">Adresa*</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['landlord_address']) ? 'error_field_form' : '';?>"
                        type="text"
                        id="landlord_address"
                        name="landlord_address"
                        value="<?= $old['landlord_address'] ?? ''; ?>"
                        data-lang="Adresa pronajímatele"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">
                    <label for="landlord_email">E-mail</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['landlord_email']) ? 'error_field_form' : '';?>"
                        type="text"
                        id="landlord_email"
                        name="landlord_email"
                        value="<?= $old['landlord_email'] ?? ''; ?>"
                        data-lang="Email pronajímatele"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">
                    <label for="landlord_phone_number">Telefon</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['landlord_phone_number']) ? 'error_field_form' : '';?>"
                        type="text"
                        id="landlord_phone_number"
                        name="landlord_phone_number"
                        value="<?= $old['landlord_phone_number'] ?? ''; ?>"
                        data-lang="Telefon pronajímatele"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">
                    <label for="landlord_account">Číslo účtu</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['landlord_account']) ? 'error_field_form' : '';?>"
                        type="text"
                        id="landlord_account"
                        name="landlord_account"
                        value="<?= $old['landlord_account'] ?? ''; ?>"
                        data-lang="Číslo účtu pronajímatele"
                    >
                </td>
            </tr>

        </table>
        <?= $tokenInput; ?>
        <div class="errors_field errors_field_table">

            <?=componet('errors', [
                'errors' => $errors,
            ]);?>

        </div>

        <div class="submit_button_div">
            <input type="submit" class="form-btn btn-submit <!--profile-form-submit-->" value="Uložit">
            <a class="form-btn btn-reset" href="landlords">Zpět</a>
        </div>
    </form>



</div>

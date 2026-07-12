<div class="user-header">
    <h3>Nový nájemník</h3>
</div>
<div class="table-container entity-table">
    <form method="post" name="tenant" action="tenants/store" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">
                    <label for="tenant_name">Jméno*</label>
                </td>
                <td class="col-2">
                    <input class="input-profile <?= !empty($errors['tenant_name']) ? 'error_field_form' : '';?>"
                           type="text"
                           name="tenant_name"
                           id="tenant_name"
                           data-lang="Jméno nájemníka"
                           value="<?= $old['tenant_name'] ?? '';?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="tenant_address">Adresa*</label>
                </td>
                <td class="col-2">
                    <input class="input-profile <?= !empty($errors['tenant_address']) ? 'error_field_form' : '';?>"
                           type="text"
                           name="tenant_address"
                           id="tenant_address"
                           data-lang="Adresa nájemníka"
                           value="<?= $old['tenant_address'] ?? '';?>"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">
                    <label for="tenant_email">E-mail</label>
                </td>
                <td class="col-2">
                    <input class="input-profile <?= !empty($errors['tenant_email']) ? 'error_field_form' : '';?>"
                           type="text"
                           name="tenant_email"
                           id="tenant_email"
                           data-lang="Email nájemníka"
                           value="<?= $old['tenant_email'] ?? '';?>"
                    >
                </td>
            </tr>


            <tr class="">
                <td class="col-1">
                    <label for="tenant_phone_number">Telefon</label>
                </td>
                <td class="col-2">
                    <input class="input-profile <?= !empty($errors['tenant_phone_number']) ? 'error_field_form' : '';?>"
                           type="text"
                           name="tenant_phone_number"
                           id="tenant_phone_number"
                           data-lang="Telefon nájemníka"
                           value="<?= $old['tenant_phone_number'] ?? '';?>"
                    >
                </td>
            </tr>


            <tr class="">
                <td class="col-1">
                    <label for="tenant_account">Číslo účtu</label>
                </td>
                <td class="col-2">
                    <input class="input-profile  <?= !empty($errors['tenant_account']) ? 'error_field_form' : '';?>"
                           type="text"
                           name="tenant_account"
                           id="tenant_account"
                           data-lang="Bankovní účet nájemníka"
                           value="<?= $old['tenant_account'] ?? '';?>"
                    >
                </td>
            </tr>

        </table>
        <?= $tokenInput; ?>
        <div class="errors_field errors_field_table">
            <?= componet('errors', ['errors' => $errors]); ?>
        </div>

        <div class="submit_button_div">
            <input type="submit" class="form-btn btn-submit " value="Uložit">
            <a class="form-btn btn-reset" href="tenants">Zpět</a>
        </div>
    </form>

</div>

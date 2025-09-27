
<div class="user-header">
    <h3>Profil nájemníka</h3>
</div>

<div class="table-container entity-table">

    <form method="post" name="tenant" action="user/tenants/update?tenant_id=<?=$tenant->id;?>" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">Jméno*</td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['tenant_name']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="tenant_name"
                        id="tenant_name"
                        data-lang="Jméno nájemníka"
                        value="<?= $old['tenant_name'] ?? $tenant->name;?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">Adresa*</td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['tenant_address']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="tenant_address"
                        id="tenant_address"
                        data-lang="Adresa nájemníka"
                        value="<?= $old['tenant_address'] ?? $tenant->address;?>"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">E-mail</td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['tenant_email']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="tenant_email"
                        id="tenant_email"
                        data-lang="Email nájemníka"
                        value="<?= $old['tenant_email'] ?? $tenant->email;?>"
                    >
                </td>
            </tr>


            <tr class="">
                <td class="col-1">Telefon</td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['tenant_phone_number']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="tenant_phone_number"
                        id="tenant_phone_number"
                        data-lang="Telefon nájemníka"
                        value="<?= $old['tenant_phone_number'] ?? $tenant->phone_number;?>"
                    >
                </td>
            </tr>


            <tr class="">
                <td class="col-1">Číslo účtu</td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['tenant_account']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="tenant_account"
                        id="tenant_account"
                        data-lang="Bankovní účet nájemníka"
                        value="<?= $old['tenant_account'] ?? $tenant->account;?>"
                    >
                </td>
            </tr>

        </table>
        <?= $tokenInput; ?>

        <div class="errors_field errors_field_table">
            <?= componet('errors', ['errors' => $errors]); ?>
        </div>


        <div class="submit_button_div">
            <input type="submit" class="form-btn btn-submit <!--profile-form-submit-->" value="Uložit">
            <a class="form-btn btn-reset" href="user/tenants/show?tenant_id=<?=$tenant->id;?>">Zpět</a>
        </div>
    </form>

</div>

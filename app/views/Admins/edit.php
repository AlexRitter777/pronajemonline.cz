<div class="user-header">
    <h3>Profil správce</h3>
</div>

<div class="table-container entity-table">

    <form method="post" name="admin" action="admins/<?=$admin->id;?>/update" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">
                    <label for="admin_name">Název*</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_name']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_name"
                        id="admin_name"
                        data-lang="Název správce"
                        value="<?= $old['admin_name'] ?? $admin->name;?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="admin_phone">Telefon</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_phone']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_phone"
                        id="admin_phone"
                        data-lang="Telefon správce"
                        value="<?= $old['admin_phone'] ?? $admin->phone;?>"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">
                    <label for="admin_email">E-mail</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_email']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_email"
                        id="admin_email"
                        data-lang="E-mail správce"
                        value="<?= $old['admin_email'] ?? $admin->email;?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="admin_tech_name">Technik</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_tech_name']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_tech_name"
                        id="admin_tech_name"
                        data-lang="Jméno technika"
                        value="<?= $old['admin_tech_name'] ?? $admin->tech_name;?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="admin_tech_phone">Technik - telefon</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_tech_phone']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_tech_phone"
                        id="admin_tech_phone"
                        data-lang="Telefon technika"
                        value="<?= $old['admin_tech_phone'] ?? $admin->tech_phone;?>"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">
                    <label for="admin_tech_email">Technik - e-mail</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_tech_email']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_tech_email"
                        id="admin_tech_email"
                        data-lang="E-mail technika"
                        value="<?= $old['admin_tech_email'] ?? $admin->tech_email;?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="admin_acc_name">Účetní</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_acc_name']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_acc_name"
                        id="admin_acc_name"
                        data-lang="Jméno účetní"
                        value="<?= $old['admin_acc_name'] ?? $admin->acc_name;?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="admin_acc_phone">Účetní - telefon</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_acc_phone']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_acc_phone"
                        id="admin_acc_phone"
                        data-lang="Telefon účetní"
                        value="<?= $old['admin_acc_phone'] ?? $admin->acc_phone;?>"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">
                    <label for="admin_acc_email">Účetní - e-mail</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['admin_acc_email']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="admin_acc_email"
                        id="admin_acc_email"
                        data-lang="E-mail účetní"
                        value="<?= $old['admin_acc_email'] ?? $admin->acc_email;?>"
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
            <input type="submit" class="form-btn btn-submit" value="Uložit">
            <a class="form-btn btn-reset" href="admins/<?=$admin->id;?>">Zpět</a>
        </div>
    </form>

</div>

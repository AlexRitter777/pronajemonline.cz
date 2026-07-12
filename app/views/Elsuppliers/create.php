<div class="user-header">
    <h3>Nový dodavatel elektřiny</h3>
</div>

<div class="table-container entity-table">
    <form method="post" name="elsupplier" action="elsuppliers/store" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">
                    <label for="elsupplier_name">Název*</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['elsupplier_name']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="elsupplier_name"
                        id="elsupplier_name"
                        data-lang="Název dodavatele elektřiny"
                        value="<?= $old['elsupplier_name'] ?? ''; ?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="elsupplier_add_info">Informace</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['elsupplier_add_info']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="elsupplier_add_info"
                        id="elsupplier_add_info"
                        data-lang="Informace"
                        value="<?= $old['elsupplier_add_info'] ?? ''; ?>"
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
            <a class="form-btn btn-reset" href="elsuppliers">Zpět</a>
        </div>
    </form>
</div>

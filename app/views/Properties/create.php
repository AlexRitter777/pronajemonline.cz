
<div class="user-header">
    <h3>Nová nemovitost</h3>
</div>

<div class="table-container entity-table">

    <form method="post" name="property" action="properties/store" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">
                    <label for="property_address">Adresa*</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['property_address']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="property_address"
                        id="property_address"
                        value="<?= $old['property_address'] ?? ''; ?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="property_type">Druh nemovitosti*</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['property_type']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="property_type"
                        id="property_type"
                        value="<?= $old['property_type'] ?? ''; ?>"
                    >
                </td>
            </tr>

            <tr class="">
                <td class="col-1">
                    <label for="property_add_info">Další informace:</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['property_add_info']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="property_add_info"
                        id="property_add_info"
                        value="<?= $old['property_add_info'] ?? ''; ?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="input_landlord_list">Pronajímatel</label>
                </td>
                <td class="col-2 landlord" id="landlord">
                    <select
                        class="input-profile select-landlord-list <?= !empty($errors['property_landlord']) ? 'error_field_form' : '';?>"
                        id="input_landlord_list"
                        name="property_landlord"
                    >
                    </select>
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="input_tenant_list">Nájemník</label>
                </td>
                <td class="col-2 tenant" id="tenant">
                    <select
                        class="input-profile select-tenant-list <?= !empty($errors['property_tenant']) ? 'error_field_form' : '';?>"
                        id="input_tenant_list"
                        name="property_tenant"
                    >
                    </select>
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="input_admin_list">Správce</label>
                </td>
                <td class="col-2 admin" id="admin">
                    <select
                        class="input-profile select-admin-list <?= !empty($errors['property_admin']) ? 'error_field_form' : '';?>"
                        id="input_admin_list"
                        name="property_admin"
                    >
                    </select>
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="input_elsupplier_list">Dodavatel elektřiny</label>
                </td>
                <td class="col-2 elsupplier" id="elsupplier">
                    <select
                        class="input-profile select-elsupplier-list <?= !empty($errors['property_elsupplier']) ? 'error_field_form' : '';?>"
                        id="input_elsupplier_list"
                        name="property_elsupplier"
                    >
                    </select>
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="property_rent_payment">Nájemné</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['property_rent_payment']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="property_rent_payment"
                        id="property_rent_payment"
                        value="<?= $old['property_rent_payment'] ?? ''; ?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="property_services_payment">Záloha na služby</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['property_services_payment']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="property_services_payment"
                        id="property_services_payment"
                        value="<?= $old['property_services_payment'] ?? ''; ?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="property_electro_payment">Záloha za elektřinu</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['property_electro_payment']) ? 'error_field_form' : '';?>"
                        type="text"
                        name="property_electro_payment"
                        id="property_electro_payment"
                        value="<?= $old['property_electro_payment'] ?? ''; ?>"
                    >
                </td>
            </tr>
            <tr class="">
                <td class="col-1">
                    <label for="property_contract_till">Nájemní smlouva do</label>
                </td>
                <td class="col-2">
                    <input
                        class="input-profile <?= !empty($errors['property_contract_till']) ? 'error_field_form' : '';?>"
                        type="date"
                        name="property_contract_till"
                        id="property_contract_till"
                        value="<?= $old['property_contract_till'] ?? ''; ?>"
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
            <input type="submit" class="form-btn btn-submit" id="profile_submit" value="Uložit">
            <a class="form-btn btn-reset" href="properties">Zpět</a>
        </div>
    </form>



</div>

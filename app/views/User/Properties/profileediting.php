
    <div class="user-header">
        <h3>Karta nemovitosti</h3>
    </div>

    <div class="central-bar">
        <button class="burger-sidebar" type="button" id="navToggle">
            <span class="burger__item">Menu</span>
        </button>


        <form method="post" data-id="<?=$property->id;?>" name="property" action="user/properties/profile-save?property_id=<?=$property->id;?>">
            <table class="tenants" border="0">

                <tr class="">
                    <td class="col-1">Adresa*</td>
                    <td class="col-2"><input class="input-profile" type="text" name="property_address" id="propertyAddress" value="<?=$property->address;?>"></td>
                </tr>
                <tr class="">
                    <td class="col-1">Druh nemovitosti*</td>
                    <td class="col-2"><input class="input-profile" type="text" name="property_type" id="propertyType" value="<?=$property->type;?>" ></td>
                </tr>

                <tr class="">
                    <td class="col-1">Další informace:</td>
                    <td class="col-2"><input class="input-profile" type="text" name="property_add_info" id="propertyAddinfo" value="<?=$property->add_info;?>"></td>
                </tr>
                <tr class="">
                    <td class="col-1">Pronajímatel</td>
                    <td class="col-2 landlord" id="landlord">
                        <select class="input-profile select-landlord-list" id="input-landlord-list" name="property_landlord" data-item="landlord">
                            <option value="<?=$property->landlord_id;?>"><?= $landlord[$property->landlord_id] ?? '';?></option>
                        </select>
                    </td>
                </tr>
                <tr class="">
                    <td class="col-1">Nájemník</td>
                    <td class="col-2 tenant" id="tenant">
                        <select class="input-profile select-tenant-list" id="input-tenant-list" name="property_tenant">
                            <option value="<?=$property->tenant_id;?>"><?=$tenant[$property->tenant_id] ?? '';?></option>
                        </select>
                    </td>
                </tr>
                <tr class="">
                    <td class="col-1">Správce</td>
                    <td class="col-2 admin" id="admin">
                        <select class="input-profile select-admin-list" id="input-admin-list" name="property_admin">
                            <option value="<?=$property->admin_id;?>"><?=$admin[$property->admin_id] ?? '';?></option>
                        </select>
                    </td>
                </tr>
                <tr class="">
                    <td class="col-1">Dodavatel elektřiny</td>
                    <td class="col-2 elsupplier" id="elsupplier">
                        <select class="input-profile select-elsupplier-list" id="input-elsupplier-list" name="property_elsupplier">
                            <option value="<?=$property->elsupplier_id;?>"><?=$elsupplier[$property->elsupplier_id] ?? '';?></option>
                        </select>
                    </td>
                </tr>




                <tr class="">
                    <td class="col-1">Nájemné</td>
                    <td class="col-2"><input class="input-profile" type="number" name="property_rent_payment" id="propertyRentpayment" value="<?= $property->rent_payment;?>"></td>
                </tr>
                <tr class="">
                    <td class="col-1">Záloha na služby</td>
                    <td class="col-2"><input class="input-profile" type="number" name="property_services_payment" id="propertyServicespayment" value="<?= $property->services_payment;?>"></td>
                </tr>
                <tr class="">
                    <td class="col-1">Záloha za elektřinu</td>
                    <td class="col-2"><input class="input-profile" type="number" name="property_electro_payment"  id="propertyElectropayment" value="<?= $property->electro_payment;?>"></td>
                </tr>

                <tr class="">
                    <td class="col-1">Nájemní smlouva do</td>
                    <td class="col-2"><input class="input-profile" type="date" name="property_contract_till"  id="propertyContracttill" value="<?= $property->contract_till;?>"></td>
                </tr>


            </table>


            <div class="errors_field errors_field_table"></div>

            <div class="property-add-buttons">
                <input type="submit" id="profile-submit" value="Uložit">
                <a href="user/properties/profile?property_id=<?=$property->id;?>">Zrušit</a>
            </div>
        </form>

    </div>





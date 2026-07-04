
<div class="user-header">
    <h3>Nová nemovitost</h3>
</div>

<div class="central-bar">
    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <form method="post" name="property" action="user/properties/save" >
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">Adresa*</td>
                <td class="col-2"><input class="input-profile" type="text" name="property_address" id="propertyAddress"></td>
            </tr>
            <tr class="">
                <td class="col-1">Druh nemovitosti*</td>
                <td class="col-2"><input class="input-profile" type="text" name="property_type" id="propertyType"></td>
            </tr>

            <tr class="">
                <td class="col-1">Další informace:</td>
                <td class="col-2"><input class="input-profile" type="text" name="property_add_info" id="propertyAddinfo" ></td>
            </tr>
            <tr class="">
                <td class="col-1">Pronajímatel</td>
                <td class="col-2 landlord" id="landlord">
                    <select class="input-profile select-landlord-list" id="input-landlord-list" name="property_landlord">
                    </select>
                </td>
            </tr>
            <tr class="">
                <td class="col-1">Nájemník</td>
                <td class="col-2 tenant" id="tenant">
                    <select class="input-profile select-tenant-list" id="input-tenant-list" name="property_tenant">
                    </select>
                </td>
            </tr>
            <tr class="">
                <td class="col-1">Správce</td>
                <td class="col-2 admin" id="admin">
                    <select class="input-profile select-admin-list" id="input-admin-list" name="property_admin">
                    </select>
                </td>
            </tr>
            <tr class="">
                <td class="col-1">Dodavatel elektřiny</td>
                <td class="col-2 elsupplier" id="elsupplier">
                    <select class="input-profile select-elsupplier-list" id="input-elsupplier-list" name="property_elsupplier">
                    </select>
                </td>
            </tr>
            <tr class="">
                <td class="col-1">Nájemné</td>
                <td class="col-2"><input class="input-profile" type="text" name="property_rent_payment" id="propertyRentpayment"></td>
            </tr>
            <tr class="">
                <td class="col-1">Záloha na služby</td>
                <td class="col-2"><input class="input-profile" type="text" name="property_services_payment" id="propertyServicespayment"></td>
            </tr>
            <tr class="">
                <td class="col-1">Záloha za elektřinu</td>
                <td class="col-2"><input class="input-profile" type="text" name="property_electro_payment" id="propertyElectropayment"></td>
            </tr>
            <tr class="">
                <td class="col-1">Nájemní smlouva do</td>
                <td class="col-2"><input class="input-profile" type="date" name="property_contract_till"  id="propertyContracttill" ></td>
            </tr>


        </table>

        <div class="errors_field errors_field_table"></div>

        <div class="tenant-add-buttons">
            <input type="submit" id="profile-submit" value="Uložit">
            <a href="user/properties">Zrušit</a>
        </div>
    </form>



</div>


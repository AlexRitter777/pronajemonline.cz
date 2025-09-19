
<div class="user-header">
    <h3>Nový pronajímatel</h3>
</div>

<div class="table-container entity-table">

    <form method="post" name="landlord" class="" action="user/landlords/save" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">Jméno*</td>
                <td class="col-2"><input class="input-profile" type="text" id="landlord_name" name="landlord_name" data-lang="Jméno pronajímatele"></td>
            </tr>
            <tr class="">
                <td class="col-1">Adresa*</td>
                <td class="col-2"><input class="input-profile" type="text" id="landlord_address" name="landlord_address" data-lang="Adresa pronajímatele"></td>
            </tr>

            <tr class="">
                <td class="col-1">E-mail</td>
                <td class="col-2"><input class="input-profile" type="text" id="landlord_email" name="landlord_email" data-lang="Email pronajímatele"></td>
            </tr>


            <tr class="">
                <td class="col-1">Telefon</td>
                <td class="col-2"><input class="input-profile"  type="text" id="landlord_phone_number" name="landlord_phone_number" data-lang="Telefon pronajímatele"></td>
            </tr>


            <tr class="">
                <td class="col-1">Číslo účtu</td>
                <td class="col-2"><input class="input-profile" type="text" id="landlord_account" name="landlord_account" data-lang="Číslo účtu pronajímatele"></td>
            </tr>


        </table>
        <?= $tokenInput; ?>
        <div class="errors_field errors_field_table"></div>


        <div class="submit_button_div">
            <input type="submit" class="form-btn btn-submit profile-form-submit" value="Uložit">
            <a class="form-btn btn-reset" href="user/landlords">Zpět</a>
        </div>
    </form>



</div>

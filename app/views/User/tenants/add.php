
<div class="user-header">
    <h3>Nový nájemník</h3>
</div>

<div class="central-bar">
    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <form method="post" name="tenant" action="user/tenants/save" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">Jméno*</td>
                <td class="col-2"><input class="input-profile" type="text" name="tenant_name" id="tenant_name" data-lang="Jméno nájemníka" ></td>
            </tr>
            <tr class="">
                <td class="col-1">Adresa*</td>
                <td class="col-2"><input class="input-profile" type="text" name="tenant_address" id="tenant_address" data-lang="Adresa nájemníka"></td>
            </tr>

            <tr class="">
                <td class="col-1">E-mail</td>
                <td class="col-2"><input class="input-profile" type="text" name="tenant_email" id="tenant_email" data-lang="Email nájemníka"></td>
            </tr>


            <tr class="">
                <td class="col-1">Telefon</td>
                <td class="col-2"><input class="input-profile"  type="text" name="tenant_phone_number" id="tenant_phone_number" data-lang="Telefon nájemníka"></td>
            </tr>


            <tr class="">
                <td class="col-1">Číslo účtu</td>
                <td class="col-2"><input class="input-profile" type="text" name="tenant_account" id="tenant_account" data-lang="Bankovní účet nájemníka"></td>
            </tr>

        </table>

        <div class="errors_field errors_field_table"></div>

        <div class="tenant-add-buttons">
            <input type="submit" value="Uložit" class="profile-form-submit">
            <a href="user/tenants">Zrušit</a>
        </div>
    </form>



</div>
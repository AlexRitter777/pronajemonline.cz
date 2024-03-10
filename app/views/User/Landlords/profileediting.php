
<div class="user-header">
    <h3>Profil pronajímatele</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <form method="post" name="landlord" action="user/landlords/profile-save?landlord_id=<?=$landlord->id;?>" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">Jméno*</td>
                <td class="col-2"><input type="text" name="landlord_name" value="<?= $landlord->name;?>" id="landlord_name" data-lang="Jméno pronajímatele"></td>
            </tr>
            <tr class="">
                <td class="col-1">Adresa*</td>
                <td class="col-2"><input type="text"  id="landlord_address" name="landlord_address" value="<?= $landlord->address;?>" data-lang="Adresa pronajímatele"></td>
            </tr>

            <tr class="">
                <td class="col-1">E-mail</td>
                <td class="col-2"><input type="text" id="landlord_email" name="landlord_email" value="<?= $landlord->email;?>" data-lang="Email pronajímatele"></td>
            </tr>


            <tr class="">
                <td class="col-1">Telefon</td>
                <td class="col-2"><input type="text" id="landlord_phone_number" name="landlord_phone_number" value="<?= $landlord->phone_number;?>" data-lang="Telefon pronajímatele"></td>
            </tr>


            <tr class="">
                <td class="col-1">Číslo účtu</td>
                <td class="col-2"><input type="text" id="landlord_account" name="landlord_account" value="<?= $landlord->account;?>" data-lang="Číslo účtu pronajímatele"></td>
            </tr>

        </table>

        <div class="errors_field errors_field_table"></div>


        <div class="tenant-add-buttons">
            <input type="submit" class="profile-form-submit" value="Uložit">
            <a href="user/landlords/profile?landlord_id=<?=$landlord->id;?>">Zrušit</a>
        </div>
    </form>



</div>


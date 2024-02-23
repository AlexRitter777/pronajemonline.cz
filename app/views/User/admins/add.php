
<div class="user-header">
    <h3>Nový správce</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>


    <form method="post" name="admin" action="user/admins/save" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">Název*</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_name" id="admin_name" data-lang="Název správce"></td>
            </tr>
            <tr class="">
                <td class="col-1">Telefon</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_phone" id="admin_phone" data-lang="Telefon správce"></td>
            </tr>

            <tr class="">
                <td class="col-1">E-mail</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_email" id="admin_email" data-lang="E-mail správce"></td>
            </tr>
            <tr class="">
                <td class="col-1">Technik</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_tech_name" id="admin_tech_name" data-lang="Jméno technika"></td>
            </tr>
            <tr class="">
                <td class="col-1">Technik - telefon</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_tech_phone" id="admin_tech_phone" data-lang="Telefon technika"></td>
            </tr>

            <tr class="">
                <td class="col-1">Technik - e-mail</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_tech_email" id="admin_tech_email" data-lang="E-mail technika"></td>
            </tr>
            <tr class="">
                <td class="col-1">Účetní</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_acc_name" id="admin_acc_name" data-lang="Jméno účetní"></td>
            </tr>
            <tr class="">
                <td class="col-1">Účetní - telefon</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_acc_phone" id="admin_acc_phone" data-lang="Telefon účetní"></td>
            </tr>

            <tr class="">
                <td class="col-1">Účetní - e-mail</td>
                <td class="col-2"><input class="input-profile" type="text" name="admin_acc_email" id="admin_acc_email" data-lang="E-mail účetní"></td>
            </tr>


        </table>

        <div class="errors_field errors_field_table"></div>

        <div class="tenant-add-buttons">
            <input type="submit" value="Uložit" class="profile-form-submit">
            <a href="user/admins">Zrušit</a>
        </div>
    </form>



</div>

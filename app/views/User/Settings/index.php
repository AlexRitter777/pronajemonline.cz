
<div class="user-header">
    <h3>Nastavení uživatele</h3>
</div>

<div class="central-bar">
    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>



    <form method="post" name="settings" action="user/settings/save" data-type="classic">
        <table class="tenants user-settings-table" border="0">

            <tr class="row-1">
                <td class="col-1">Email/Login</td>
                <td class="col-2" id="user_email"><?= $_SESSION['useremail'];?></td>
            </tr>

            <tr class="row-2">
                <td class="col-1"></td>
                <td class="col-2"><button type="button" data-item="change_password" data-title="Změnit heslo" class="submit_button change_password">Změnit heslo</button></td>
            </tr>

            <tr class="row-3">
                <td class="col-1">Jméno uživatele</td>
                <td class="col-2"><input class="input-profile" type="text" value="<?= $_SESSION['username'];?>" name="user_name" id="user_name" data-lang="Jméno uživatele" ></td>
            </tr>


        </table>


        <div class="errors_field errors_field_table"></div>

        <div class="tenant-add-buttons save-settings-btn">
            <input type="submit" value="Uložit" class="profile-form-submit">
        </div>
    </form>







</div>





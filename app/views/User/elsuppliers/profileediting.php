
<div class="user-header">
    <h3>Profil dodavatele elektřiny</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <form method="post" name="elsupplier" action="user/elsuppliers/profile-save?elsupplier_id=<?=$elsupplier->id;?>" data-type="classic">
        <table class="tenants" border="0">

            <tr class="">
                <td class="col-1">Název*</td>
                <td class="col-2"><input class="input-profile" type="text" name="elsupplier_name" id="elsupplier_name" data-lang="Název dodavatele elektřiny" value="<?=$elsupplier->name;?>"></td>
            </tr>
            <tr class="">
                <td class="col-1">Informace</td>
                <td class="col-2"><input class="input-profile" type="text" name="elsupplier_add_info" id="elsupplier_add_info" data-lang="Informace" value="<?=$elsupplier->add_info;?>"></td>
            </tr>

        </table>

        <div class="errors_field errors_field_table"></div>

        <div class="tenant-add-buttons">
            <input type="submit" value="Uložit" class="profile-form-submit">
            <a href="user/elsuppliers/profile?elsupplier_id=<?=$elsupplier->id;?>">Zrušit</a>
        </div>
    </form>



</div>



<div class="user-header">
    <h3>Profil uživatele</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <table class="tenants" border="0">

        <tr class="">
            <td class="col-1">Jmeno:</td>
            <td class="col-2" id="admin-profile-name"><?= $user->username;?></td>
        </tr>
        <tr class="">
            <td class="col-1">Email:</td>
            <td class="col-2" id="admin-profile-name"><?= $user->email;?></td>
        </tr>
        <tr class="">
            <td class="col-1">ID:</td>
            <td class="col-2" id="admin-profile-name"><?= $user->id;?></td>
        </tr>
        <tr class="">
            <td class="col-1">Active</td>
            <td class="col-2"><?= ($user->active) ? 'Yes' : 'No'; ?></td>
        </tr>


    </table>
    <div class="tenant-profile-buttons">
        <button onClick="history.back()">Zpět</button>
        <a href="user/admins/profile-editing?user_id=<?=$user->id;?>" style="pointer-events: none; color: gray; border-color: gray">Upravit</a>
        <a href="" data-item="admin" style="pointer-events: none; color: gray; border-color: gray" data-href="admin/users/profile-delete?admin_id=<?=$user->id;?>" id="profile-delete">Smazat</a>
    </div>
</div>



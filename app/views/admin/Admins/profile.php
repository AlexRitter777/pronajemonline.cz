
<div class="user-header">
    <h3>Profil správce</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <table class="tenants" border="0">

        <tr class="">
            <td class="col-1">Uživatel:</td>
            <td class="col-2" id="admin-profile-name"><?= $user->username;?></td>
        </tr>
        <tr class="">
            <td class="col-1">Email uživatele:</td>
            <td class="col-2" id="admin-profile-name"><?= $user->email;?></td>
        </tr>
        <tr class="">
            <td class="col-1">ID uživatele:</td>
            <td class="col-2" id="admin-profile-name"><?= $user->id;?></td>
        </tr>
        <tr class="">
            <td class="col-1"></td>
            <td class="col-2"></td>
        </tr>

        <tr class="name">
            <td class="col-1">Název:</td>
            <td class="col-2" id="admin-profile-name"><?= $admin->name;?></td>
        </tr>
        <?php if($admin->phone): ?>
        <tr class="">
            <td class="col-1">Telefon:</td>
            <td class="col-2"><?= $admin->phone;?></td>
        </tr>
        <?php endif;?>
        <?php if($admin->email): ?>
            <tr class="">
                <td class="col-1">E-mail:</td>
                <td class="col-2"><?= $admin->email;?></td>
            </tr>
        <?php endif;?>
        <?php if($admin->tech_name): ?>
            <tr class="">
                <td class="col-1">Technik:</td>
                <td class="col-2"><?= $admin->tech_name;?></td>
            </tr>
        <?php endif;?>
        <?php if($admin->tech_phone): ?>
            <tr class="">
                <td class="col-1">Technik - telefon:</td>
                <td class="col-2"><?= $admin->tech_phone;?></td>
            </tr>
        <?php endif;?>
        <?php if($admin->tech_email): ?>
            <tr class="">
                <td class="col-1">Technik - e-mail:</td>
                <td class="col-2"><?= $admin->tech_email;?></td>
            </tr>
        <?php endif;?>
        <?php if($admin->acc_name): ?>
            <tr class="">
                <td class="col-1">Účetní:</td>
                <td class="col-2"><?= $admin->acc_name;?></td>
            </tr>
        <?php endif;?>
        <?php if($admin->acc_phone): ?>
            <tr class="">
                <td class="col-1">Účetní - telefon:</td>
                <td class="col-2"><?= $admin->acc_phone;?></td>
            </tr>
        <?php endif;?>
        <?php if($admin->acc_email): ?>
            <tr class="">
                <td class="col-1">Účetní - e-mail:</td>
                <td class="col-2"><?= $admin->acc_email;?></td>
            </tr>
        <?php endif;?>
        <?php if($propertyList): ?>
            <tr class="property-list">
                <td class="col-1">Nemovitosi</td>
                <td class="col-2">
                    <?php foreach ($propertyList as $property): ?>
                        <a href="/user/properties/profile?property_id=<?= $property['id'];?>>"><?= $property['address'];?></a><br>
                    <?php endforeach;?>
                </td>
            </tr>
        <?php endif;?>




    </table>
    <div class="tenant-profile-buttons">
        <button onClick="history.back()">Zpět</button>
        <a href="user/admins/profile-editing?admin_id=<?=$admin->id;?>" style="pointer-events: none; color: gray; border-color: gray">Upravit</a>
        <a href="" data-item="admin" data-href="user/admins/profile-delete?admin_id=<?=$admin->id;?>" id="profile-delete" style="pointer-events: none; color: gray; border-color: gray">Smazat</a>
    </div>
</div>



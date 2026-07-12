<div class="user-header">
    <h3>Profil správce</h3>
</div>

<div class="table-container entity-table">

    <table class="tenants" border="0">

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
                <td class="col-1">Nemovitosti</td>
                <td class="col-2">
                    <?php foreach ($propertyList as $property): ?>
                        <a href="/user/properties/profile?property_id=<?= $property['id'];?>>"><?= $property['address'];?></a><br>
                    <?php endforeach;?>
                </td>
            </tr>
        <?php endif;?>

    </table>
    <div class="submit_button_div">
        <a class="form-btn btn-submit" href="admins">Zpět</a>
        <a class="form-btn btn-submit" href="admins/<?=$admin->id;?>/edit">Upravit</a>
        <a class="form-btn btn-reset" data-item="admin" data-id="<?=$admin->id;?>" data-href="admins/destroy" id="profile-delete">Smazat</a>
    </div>
</div>

<?php require_once APP . '/views/includes/modal_del_confirmation.php'; ?>

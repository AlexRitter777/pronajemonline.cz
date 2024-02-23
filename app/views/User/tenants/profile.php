
<div class="user-header">
    <h3>Profil nájemníka</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <table class="tenants" border="0">

            <tr class="name">
                <td class="col-1">Jméno:</td>
                <td class="col-2" id="tenant-profile-name"><?= $tenant->name;?></td>
            </tr>
            <tr class="">
                <td class="col-1">Adresa:</td>
                <td class="col-2"><?= $tenant->address;?></td>
            </tr>
            <?php if($tenant->email): ?>
            <tr class="">
                <td class="col-1">E-mail:</td>
                <td class="col-2"><?= $tenant->email;?></td>
            </tr>
            <?php endif;?>
            <?php if($tenant->phone_number): ?>
                <tr class="">
                    <td class="col-1">Telefon:</td>
                    <td class="col-2"><?= $tenant->phone_number;?></td>
                </tr>
            <?php endif;?>
            <?php if($tenant->account): ?>
                <tr class="">
                    <td class="col-1">Číslo účtu:</td>
                    <td class="col-2"><?= $tenant->account;?></td>
                </tr>
            <?php endif;?>
            <?php if($propertyList): ?>
                <tr class="property-list">
                    <td class="col-1">Pronajímá si:</td>
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
        <a href="user/tenants/profile-editing?tenant_id=<?=$tenant->id;?>">Upravit</a>
        <a href="" data-item="tenant" data-href="user/tenants/profile-delete?tenant_id=<?=$tenant->id;?>" id="profile-delete">Smazat</a>
    </div>
</div>






<div class="user-header">
    <h3>Profil pronajímatele</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <table class="tenants" border="0">

        <tr class="name">
            <td class="col-1">Jméno:</td>
            <td class="col-2" id="landlord-profile-name"><?= $landlord->name;?></td>
        </tr>
        <tr class="">
            <td class="col-1">Adresa:</td>
            <td class="col-2"><?= $landlord->address;?></td>
        </tr>
        <?php if($landlord->email): ?>
            <tr class="">
                <td class="col-1">E-mail:</td>
                <td class="col-2"><?= $landlord->email;?></td>
            </tr>
        <?php endif;?>
        <?php if($landlord->phone_number): ?>
            <tr class="">
                <td class="col-1">Telefon:</td>
                <td class="col-2"><?= $landlord->phone_number;?></td>
            </tr>
        <?php endif;?>
        <?php if($landlord->account): ?>
            <tr class="">
                <td class="col-1">Číslo účtu:</td>
                <td class="col-2"><?= $landlord->account;?></td>
            </tr>
        <?php endif;?>
        <?php if($propertyList): ?>
            <tr class="property-list">
                <td class="col-1">Pronajímá:</td>
                <td class="col-2">
                    <?php foreach ($propertyList as $property): ?>
                        <a href="user/properties/profile?property_id=<?=$property['id'];?>"><?= $property['address'];?></a><br>
                    <?php endforeach;?>
                </td>
            </tr>
        <?php endif;?>

    </table>
    <div class="tenant-profile-buttons">
        <button onClick="history.back()">Zpět</button>
        <a href="user/landlords/profile-editing?landlord_id=<?=$landlord->id;?>">Upravit</a>
        <a href="" data-item="landlord" data-href="user/landlords/profile-delete?landlord_id=<?=$landlord->id;?>" id="profile-delete">Smazat</a>
    </div>
</div>



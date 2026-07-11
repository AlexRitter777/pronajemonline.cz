
<div class="user-header">
    <h3>Profil pronajímatele</h3>
</div>

<div class="table-container entity-table">

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

    <div class="submit_button_div">
        <a class="form-btn btn-submit" href="landlords">Zpět</a>
        <a class="form-btn btn-submit" href="landlords/<?=$landlord->id;?>/edit">Upravit</a>
        <a class="form-btn btn-reset" data-item="landlord" data-id="<?=$landlord->id;?>" data-href="landlords/destroy" id="profile-delete">Smazat</a>
    </div>


</div>


<?php require_once APP . '/views/includes/modal_del_confirmation.php'; ?>
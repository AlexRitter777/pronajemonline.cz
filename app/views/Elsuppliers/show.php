<div class="user-header">
    <h3>Profil dodavatele elektřiny</h3>
</div>

<div class="table-container entity-table">

    <table class="tenants" border="0">

        <tr class="name">
            <td class="col-1">Název:</td>
            <td class="col-2" id="elsupplier-profile-name"><?= $elsupplier->name;?></td>
        </tr>
        <?php if($elsupplier->add_info): ?>
        <tr class="">
            <td class="col-1">Informace:</td>
            <td class="col-2"><?= $elsupplier->add_info;?></td>
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
        <a class="form-btn btn-submit" href="elsuppliers">Zpět</a>
        <a class="form-btn btn-submit" href="elsuppliers/<?=$elsupplier->id;?>/edit">Upravit</a>
        <a class="form-btn btn-reset" data-item="elsupplier" data-id="<?=$elsupplier->id;?>" data-href="elsuppliers/destroy" id="profile-delete">Smazat</a>
    </div>
</div>

<?php require_once APP . '/views/includes/modal_del_confirmation.php'; ?>

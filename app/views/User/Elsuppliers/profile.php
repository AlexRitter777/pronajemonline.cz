
<div class="user-header">
    <h3>Profil dodavatele elektřiny</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

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
    <div class="tenant-profile-buttons">
        <button onClick="history.back()">Zpět</button>
        <a href="user/elsuppliers/profile-editing?elsupplier_id=<?=$elsupplier->id;?>">Upravit</a>
        <a href="" data-item="elsupplier" data-href="user/elsuppliers/profile-delete?elsupplier_id=<?=$elsupplier->id;?>" id="profile-delete">Smazat</a>
    </div>
</div>



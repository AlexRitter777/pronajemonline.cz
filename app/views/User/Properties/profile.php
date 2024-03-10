
<div class="user-header">
    <h3>Karta nemovitosti</h3>
</div>

<div class="central-bar">
    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <table class="tenants property-profile-table" border="0">

        <tr class="name">
            <td class="col-1">Adresa:</td>
            <td class="col-2" id="property-profile-name"><?= $property->address;?></td>
        </tr>
        <tr class="">
            <td class="col-1">Druh nemovitosti:</td>
            <td class="col-2"><?= $property->type;?></td>
        </tr>
        <?php if($property->add_info): ?>
            <tr class="">
                <td class="col-1">Další informace:</td>
                <td class="col-2"><?= $property->add_info;?></td>
            </tr>
        <?php endif;?>
        <?php if($property->rent_payment): ?>
            <tr class="">
                <td class="col-1">Nájemné:</td>
                <td class="col-2"><?= $property->rent_payment;?> Kč</td>
            </tr>
        <?php endif;?>
        <?php if($property->services_payment): ?>
            <tr class="">
                <td class="col-1">Záloha na služby:</td>
                <td class="col-2"><?= $property->services_payment;?> Kč</td>
            </tr>
        <?php endif;?>
        <?php if($property->electro_payment): ?>
            <tr class="">
                <td class="col-1">Záloha za elektřinu:</td>
                <td class="col-2"><?= $property->electro_payment;?> Kč</td>
            </tr>
        <?php endif;?>
        <?php if(isset($tenant[$property->tenant_id])): ?>
            <tr class="tenant">
                <td class="col-1">Nájemník:</td>
                <td class="col-2"><a href="/user/tenants/profile?tenant_id=<?=$property->tenant_id;?>"><?= $tenant[$property->tenant_id];?></a></td>
            </tr>
        <?php endif;?>
        <?php if(isset($landlord[$property->landlord_id])): ?>
            <tr class="">
                <td class="col-1">Pronajímatel:</td>
                <td class="col-2"><a href="/user/landlords/profile?landlord_id=<?=$property->landlord_id;?>"><?= $landlord[$property->landlord_id];?></a></td>
            </tr>
        <?php endif;?>
        <?php if(isset($admin[$property->admin_id])): ?>
            <tr class="">
                <td class="col-1">Správce:</td>
                <td class="col-2"><a href="/user/admins/profile?admin_id=<?=$property->admin_id;?>"><?= $admin[$property->admin_id];?></a></td>
            </tr>
        <?php endif;?>
        <?php if(isset($elsupplier[$property->elsupplier_id])): ?>
            <tr class="">
                <td class="col-1">Dodavatel elektřiny:</td>
                <td class="col-2"><a href="/user/elsuppliers/profile?elsupplier_id=<?=$property->elsupplier_id;?>"><?= $elsupplier[$property->elsupplier_id];?></a></td>
            </tr>
        <?php endif;?>
        <?php if($property->contract_till): ?>
            <tr class="">
                <td class="col-1">Nájemní smlouva do:</td>
                <td class="col-2"><?= date("d.m.Y", strtotime($property->contract_till));?> </td>
            </tr>
        <?php endif;?>

    </table>
    <div class="tenant-profile-buttons">
        <a href="user/properties">Zpět na seznam</a>
        <a href="user/properties/profile-editing?property_id=<?=$property->id;?>">Upravit</a>
        <a href="" data-item="property" data-href="user/properties/profile-delete?property_id=<?=$property->id;?>" id="profile-delete">Smazat</a>
    </div>
</div>





<svg style="display:none;">
    <!--Help icon-->
    <symbol id="help" viewBox="0 0 24 24">
        <g>
            <path d="M0 0h24v24H0z" fill="none" />
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
        </g>
    </symbol>
</svg>

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
                <td class="col-1">
                    Nájemní smlouva do:
                </td>
                <td class="col-2"><?= date("d.m.Y", strtotime($property->contract_till));?>
                    <svg class="icon_help help-right-text" data-hint="#real-hint-1">
                        <use xlink: href="#help"></use>
                    </svg>
                </td>
            </tr>
        <?php endif;?>

    </table>
    <div class="tenant-profile-buttons">
        <a href="user/properties">Zpět na seznam</a>
        <a href="user/properties/profile-editing?property_id=<?=$property->id;?>">Upravit</a>
        <a href="" data-item="property" data-href="user/properties/profile-delete?property_id=<?=$property->id;?>" id="profile-delete">Smazat</a>
    </div>
</div>



<?php require_once APP . "/views/Short_hints/property_hints.php"; ?>
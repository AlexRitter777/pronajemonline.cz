<div class="user-header">
    <h3>Můj účet - <?= $_SESSION['username'];?></h3>
</div>

<button class="burger-sidebar" type="button" id="navToggle">
    <span class="burger__item">Menu</span>
</button>

<div class="central-bar">
    <div class="account-items-container">
        <div class="account-item-container">
            <div class="account-item">
                <p class="account-item-title">Pronajímatele:</p>
                <a class="account-item-count" href="/user/landlords"><?=$count['landlord']?></a>
            </div>
        </div>
        <div class="account-item-container">
            <div class="account-item">
                <p class="account-item-title">Nájemníci:</p>
                <a class="account-item-count" href="/user/tenants"><?=$count['tenant']?></a>
            </div>
        </div>
        <div class="account-item-container">
            <div class="account-item">
                <p class="account-item-title">Nemovitosti:</p>
                <a class="account-item-count" href="/user/properties"><?=$count['property']?></a>
            </div>
        </div>
        <div class="account-item-container">
            <div class="account-item">
                <p class="account-item-title">Správci:</p>
                <a class="account-item-count" href="/user/admins"><?=$count['admin']?></a>
            </div>
        </div>
        <div class="account-item-container">
            <div class="account-item">
                <p class="account-item-title">Dodavatelé elektřiny:</p>
                <a class="account-item-count" href="/user/elsuppliers"><?=$count['elsupplier']?></a>
            </div>
        </div>
    </div>

    <h4 class="dashboard-calc-title">Poslední vyúčtování</h4>

    <?php if(!empty($calculations)): ?>

        <?php foreach ($calculations as $name => $calculation): ?>
            <?php if($calculation): ?>
            <div class="dashboard-table-container">
                <h5 class="dashboard-calc-subtitle"><?= $name; ?></h5>
                <table class="calculation-titles account-index-table dashboard-table" border="0">
                    <tr class="row-1">
                        <th class="col-1">Název</th>
                        <th class="col-2">Nemovitost</th>
                        <th class="col-3">Nájemník</th>
                        <th class="col-4">Období</th>
                        <th class="col-5">Vytvořeno</th>
                        <th class="col-6">Změněno</th>
                    </tr>

                    <?php foreach ($calculation as $calc): ?>
                    <tr class="row-click" data-href="/applications/<?=$calcTypes[$name]; ?>?calculation_id=<?=$calc->id;?>">
                        <td class="col-1"><?= $calc->calculation_name; ?></td>
                        <td class="col-2"><?= $calc->property_address; ?></td>
                        <td class="col-3"><?= $calc->tenant_name; ?></td>
                        <?php if($calcTypes[$name] === 'depositcalc'): ?>
                            <td class="col-4"><?= date("d.m.Y", strtotime($calc->contract_start_date)) . ' - ' . date("d.m.Y", strtotime($calc->contract_finish_date));?></td>
                        <?php elseif($calcTypes[$name] === 'easyservicescalc'): ?>
                            <td class="col-4"><?= date("Y", strtotime($calc->rent_year_date));?></td>
                        <?php elseif($calcTypes[$name] === 'totalcalc'): ?>
                            <td class="col-4">-</td>
                        <?php else: ?>
                            <td class="col-4"><?= date("d.m.Y", strtotime($calc->rent_start_date)) . ' - ' . date("d.m.Y", strtotime($calc->rent_finish_date));?></td>
                        <?php endif;?>
                        <td class="col-5"><?= date("d.m.Y", strtotime($calc->created_at)); ?></td>
                        <td class="col-6"><?= date("d.m.Y", strtotime($calc->updated_at)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <div class="more-calc-btn"><a href="/user/calculations?calc_type=<?= $calcTypes[$name];?>">Ukázat vše...</a></div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>


    <?php else: ?>

    <p class="empty-data">Nemáte uložené žádné vyúčtování!</p>

    <?php endif; ?>

</div>

<div class="user-header">
    <h3>Nemovitosti</h3>
</div>

<div class="table-container">

    <?php if($properties): ?>
        <table class="account-table" border="0">
            <tr class="row-1">
                <th class="col-1">Adresa</th>
                <th class="col-2">Druh</th>
                <th class="col-3">Nájemník</th>
                <th class="col-4">Smlouva</th>
                <th class="col-5">Nájem</th>
                <th class="col-6">Služby</th>
                <th class="col-7">Elektřina</th>
                <th class="col-8"></th>

            </tr>


            <?php foreach ($properties as $property): ?>
                <tr class="row-click" data-href="user/properties/profile?property_id=<?=$property->id;?>">
                    <td class="col-1"><?= $property->address;?></td>
                    <td class="col-2"><?= $property->type;?></td>
                    <td class="col-3"><?= !empty($tenant[$property->tenant_id]) ? $tenant[$property->tenant_id] : '-';?></td>
                    <td class="col-4"><?= !empty($property->contract_till) ? date("d.m.Y", strtotime($property->contract_till)) : '-';?></td>
                    <td class="col-5"><?= !empty($property->rent_payment) ? $property->rent_payment : '-';?></td>
                    <td class="col-6"><?= !empty($property->services_payment) ? $property->services_payment : '-';?></td>
                    <td class="col-7"><?= !empty($property->electro_payment) ? $property->electro_payment : '-';?></td>
                    <td class="col-8">
                        <?=componet('delete-modal-form', [
                            'entityId' => $property->id,
                            'entityName' => 'property',
                            'token' => $token
                        ]);?>
                    </td>

                </tr>
            <?php endforeach;?>

        </table>
        <div class="text-center pagination-wrapper">
            <?php if($pagination->countPages > 1): ?>
                <?= $pagination; ?>
            <?php endif; ?>
        </div>


    <?php else:?>
        <p class="empty-data">Nemáte uložené žádné nemovitosti!</p>
    <?php endif;?>

    <div class="more-calc-btn">
        <a class="new-entity-button" href="user/properties/add">Nová nemovitost</a>
    </div>
</div>


<div id="del-conf" class="modal_del_confirmation">
    <div class="small_modal_wrapper">
        <div><span class="modal_confirm_btn" data-href="user/properties/profile-delete?property_id=">Smazat</span></div>
        <div><span class="modal_cancel_btn">Storno</span></div>
    </div>
</div>
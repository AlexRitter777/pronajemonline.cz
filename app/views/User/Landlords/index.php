
<div class="user-header">
    <h3>Pronajímatele</h3>
</div>

<div class="table-container">
    <?php if($landlords): ?>
        <table class="landlord-titles account-table" border="0">

            <tr class="row-1">
                <th class="col-1">Jméno</th>
                <th class="col-2">Adresa</th>
                <th class="col-3">Nemovitost</th>
                <th class="col-4">
                    <div class="title-order">
                        Vytvořen
<!--                        <div class="icons-order">-->
<!--                            <a href="--><?php //echo($accountModel->replaceUrlFilterOrder('crt-up'));?><!--">-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" width="10.033" height="5">-->
<!--                                    <path d="M5.016 0 0 .003 2.506 2.5 5.016 5l2.509-2.5L10.033.003 5.016 0z"/>-->
<!--                                </svg>-->
<!--                            </a>-->
<!--                            <a href="--><?php //echo($accountModel->replaceUrlFilterOrder('crt-down'));?><!--">-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" width="10.033" height="5" style="transform: rotate(180deg)">-->
<!--                                    <path d="M5.016 0 0 .003 2.506 2.5 5.016 5l2.509-2.5L10.033.003 5.016 0z"/>-->
<!--                                </svg>-->
<!--                            </a>-->
<!--                        </div>-->
                    </div>
                </th>
                <th class="col-5"></th>
            </tr>

            <?php foreach ($landlords as $landlord): ?>
                <tr class="row-click" data-href="user/landlords/show?landlord_id=<?=$landlord->id;?>">
                    <td class="col-1"><?= $landlord->name;?></td>
                    <td class="col-2"><?= $landlord->address;?></td>
                    <td class="col-3"><?= !empty($landlordProp[$landlord->id]) ? $landlordProp[$landlord->id] : ''; ?></td>
                    <td class="col-4"><?= $landlord->created_at ? date("d.m.Y", strtotime($landlord->created_at)) : ' - '?></td>
                    <td class="col-4 relative">
                    <?=componet('delete-modal-form', [
                        'entityId' => $landlord->id,
                        'entityName' => 'landlord',
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
        <p class="empty-data">Nemáte uložené žádné pronajímatele.</p>
    <?php endif;?>

    <div class="more-calc-btn">
        <a class="new-entity-button" href="user/landlords/create">Nový pronajímatel</a>
    </div>

</div>


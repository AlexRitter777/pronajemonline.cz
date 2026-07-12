<div class="user-header">
    <h3>Dodavatelé elektřiny</h3>
</div>

<div class="table-container">
    <?php if($elsuppliers): ?>
        <table class="elsupplier-titles account-table" border="0">
            <tr class="row-1">
                <th class="col-1">Název</th>
                <th class="col-2">Informace</th>
                <th class="col-3">
                    <div class="title-order">
                        Vytvořen
                    </div>
                </th>
                <th class="col-4"></th>
            </tr>

            <?php foreach ($elsuppliers as $elsupplier): ?>
                <tr class="row-click" data-href="elsuppliers/<?=$elsupplier->id;?>">
                    <td class="col-1"><?= $elsupplier->name;?></td>
                    <td class="col-2"><?= !empty($elsupplier->add_info) ? $elsupplier->add_info : '-';?></td>
                    <td class="col-3"><?= $elsupplier->created_at ? date("d.m.Y", strtotime($elsupplier->created_at)) : ' - '?></td>
                    <td class="col-4 relative">
                        <?=componet('delete-modal-form', [
                            'entityId' => $elsupplier->id,
                            'entityName' => 'elsupplier',
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
        <p class="empty-data">Nemáte uložené žádné dodavatele elektřiny.</p>
    <?php endif;?>

    <div class="more-calc-btn">
        <a class="new-entity-button" href="elsuppliers/create">Nový dodavatel elektřiny</a>
    </div>
</div>

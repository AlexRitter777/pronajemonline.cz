<div class="user-header">
    <h3>Správci</h3>
</div>

<div class="table-container">
    <?php if($admins): ?>
        <table class="admin-titles account-table" border="0">
            <tr class="row-1">
                <th class="col-1">Název</th>
                <th class="col-2">Telefon</th>
                <th class="col-3">E-mail</th>
                <th class="col-4">
                    <div class="title-order">
                        Vytvořen
                    </div>
                </th>
                <th class="col-5"></th>
            </tr>

            <?php foreach ($admins as $admin): ?>
                <tr class="row-click" data-href="admins/<?=$admin->id;?>">
                    <td class="col-1"><?= $admin->name;?></td>
                    <td class="col-2"><?= !empty($admin->phone) ? $admin->phone : '-';?></td>
                    <td class="col-3"><?= !empty($admin->email) ? $admin->email : '-'; ?></td>
                    <td class="col-4"><?= $admin->created_at ? date("d.m.Y", strtotime($admin->created_at)) : ' - '?></td>
                    <td class="col-5 relative">
                        <?=componet('delete-modal-form', [
                            'entityId' => $admin->id,
                            'entityName' => 'admin',
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
        <p class="empty-data">Nemáte uložené žádné správce.</p>
    <?php endif;?>

    <div class="more-calc-btn">
        <a class="new-entity-button" href="admins/create">Nový správce</a>
    </div>
</div>

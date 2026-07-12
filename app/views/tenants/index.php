<div class="user-header">
    <h3>Nájemníci</h3>
</div>

<div class="table-container">
    <?php if ($tenants): ?>
        <table class="tenant-titles account-table" border="0">
            <tr class="row-1">
                <th class="col-1">Jméno</th>
                <th class="col-2">Adresa</th>
                <th class="col-3">Nemovitost</th>
                <th class="col-4">
                    <div class="title-order">
                        Vytvořen
                    </div>
                </th>
                <th class="col-5"></th>
            </tr>

            <?php foreach ($tenants as $tenant): ?>
                <tr class="row-click" data-href="tenants/<?= $tenant->id; ?>">
                    <td class="col-1"><?= $tenant->name; ?></td>
                    <td class="col-2"><?= $tenant->address; ?></td>
                    <td class="col-3"><?= !empty($tenantProp[$tenant->id]) ? $tenantProp[$tenant->id] : ''; ?></td>
                    <td class="col-4"><?= $tenant->created_at ? date("d.m.Y", strtotime($tenant->created_at)) : ' - ' ?></td>
                    <td class="col-5">
                        <?= componet('delete-modal-form', [
                            'entityId' => $tenant->id,
                            'entityName' => 'tenant',
                            'token' => $token
                        ]); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="text-center pagination-wrapper">
            <?php if ($pagination->countPages > 1): ?>
                <?= $pagination; ?>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <p class="empty-data">Nemáte uložené žádné nájemníky</p>
    <?php endif; ?>

    <div class="more-calc-btn">
        <a class="new-entity-button" href="tenants/create">Nový nájemník</a>
    </div>

</div>





<div class="user-header">
    <h3>Vyúčtování</h3>
</div>

<div class="table-container">

        <nav class="calc-type-tabs">
           <?php foreach ($settlementTypes as $type => $label): ?>
                <a
                    href="/settlements?calc_type=<?= $type; ?>"
                    class="calc-tab <?= $settlementType->value === $type ? 'is-active' : ''; ?>"
                >
                    <?= $label; ?>
                </a>
            <?php endforeach; ?>
        </nav>

    <?php if($settlements):?>

        <table class="calculations-table account-table" border="0">
            <tr class="row-1">
                <th class="col-1">Název</th>
                <th class="col-2">
                    <div class="title-order title-filter">
                        <span>Nemovitost</span>
                    </div>
                </th>
                <th class="col-3">
                    <div class="title-order title-filter">
                        <span>Nájemník</span>
                    </div>
                </th>
                <th class="col-4">Období</th>
                <th class="col-5">
                    <div class="title-order">
                        Vytvořeno
                        <div class="icons-order">
                            <a href="<?= url_replace_query_param('ordered', 'crt-up'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.033" height="5">
                                    <path d="M5.016 0 0 .003 2.506 2.5 5.016 5l2.509-2.5L10.033.003 5.016 0z"/>
                                </svg>
                            </a>
                            <a href="<?= url_replace_query_param('ordered', 'crt-down'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.033" height="5" style="transform: rotate(180deg)">
                                    <path d="M5.016 0 0 .003 2.506 2.5 5.016 5l2.509-2.5L10.033.003 5.016 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </th>
                <th class="col-6">
                    <div class="title-order">
                        Změněno
                        <div class="icons-order">
                            <a href="<?= url_replace_query_param('ordered', 'upd-up'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.033" height="5">
                                    <path d="M5.016 0 0 .003 2.506 2.5 5.016 5l2.509-2.5L10.033.003 5.016 0z"/>
                                </svg>
                            </a>
                            <a href="<?= url_replace_query_param('ordered', 'upd-down'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.033" height="5" style="transform: rotate(180deg)">
                                    <path d="M5.016 0 0 .003 2.506 2.5 5.016 5l2.509-2.5L10.033.003 5.016 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </th>
                <th class="col-7"></th>
            </tr>


            <?php foreach ($settlements as $settlement): ?>
                <tr class="row-click" <!--data-href="/applications/<?php /*= $calcURL; */?>-calc?calculation_id=--><?php /*=$settlement->id;*/?>">
                    <td class="col-1"><?= $settlement->calculation_name;?></td>
                    <td class="col-2"><?= $settlement->property_address;?></td>
                    <td class="col-3"><?= $settlement->tenant_name;?></td>
                    <?php if($settlementType === \app\Enum\SettlementType::DEPOSIT): ?>
                        <td class="col-4"><?= date("d.m.Y", strtotime($settlement->contract_start_date)) . ' - ' . date("d.m.Y", strtotime($settlement->contract_finish_date));?></td>
                    <?php elseif($settlementType === \app\Enum\SettlementType::EASY_SERVICES): ?>
                        <td class="col-4"><?= $settlement->rent_year_date; ?></td>
                    <?php elseif($settlementType === \app\Enum\SettlementType::TOTAL): ?>
                        <td class="col-4">-</td>
                    <?php else: ?>
                        <td class="col-4"><?= date("d.m.Y", strtotime($settlement->rent_start_date)) . ' - ' . date("d.m.Y", strtotime($settlement->rent_finish_date));?></td>
                    <?php endif;?>
                    <td class="col-5"><?= date("d.m.Y", strtotime($settlement->created_at));?></td>
                    <td class="col-6"><?= date("d.m.Y", strtotime($settlement->updated_at));?></td>
                    <td class="col-7 relative">
                        <?=componet('delete-modal-form', [
                            'entityId' => $settlementType->value . ':' . $settlement->id,
                            'entityName' => 'settlement',
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
        <p class="empty-data">Nemáte uložené žádné <?= lcfirst($settlementType->label()); ?>.</p>
    <?php endif;?>

    <div class="more-calc-btn">
        <a class="new-entity-button" href="#">Nové <?= lcfirst($settlementType->label()); ?></a>
    </div>

    <?php //debug($servicesCalculations); ?>




    </div>


    <style>
        .calc-type-tabs {
            display: flex;
            gap: 4px;
            border-bottom: 2px solid #e5e5e5;
            margin: 16px 0;
        }

        .calc-tab {
            padding: 10px 18px;
            text-decoration: none;
            color: #666;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.15s;
        }

        .calc-tab:hover {
            color: #333;
        }

        .calc-tab.is-active {
            color: #000;
            border-bottom-color: #2563eb;
            font-weight: 500;
        }



    </style>


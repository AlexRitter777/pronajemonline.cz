
<div class="user-header">
    <h3>Vyúčtování</h3>
</div>

<div class="table-container">

<!--    <div class="calculation-select-type">-->
<!--        <form method="get" class="calc_type_form" action="settlements">-->
<!---->
<!--            <select-->
<!--                    x-data="select2({-->
<!--                        placeholder: 'Vyberte nemovitost',-->
<!--                        minimumResultsForSearch: 2-->
<!--                    })"-->
<!--                    name="property_id"-->
<!--                    class="select-calctype"-->
<!--                    id="calc-type-list"-->
<!--                    @change="$el.form.submit()"-->
<!--            >-->
<!--                --><?php //foreach ($properties as $id => $address): ?>
<!--                    <option></option>-->
<!--                    <option-->
<!--                        value="--><?php //= $id; ?><!--"-->
<!--                        --><?php //if((string) $selectedPropertyId === (string) $id): ?><!--selected--><?php //endif; ?>
<!--                    >-->
<!--                        --><?php //= $address; ?>
<!--                    </option>-->
<!--                --><?php //endforeach; ?>
<!--            </select>-->
<!--        </form>-->
<!--    </div>-->

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


    <?php if($settlements === null):?>
        <p class="empty-data">Pro zobrazení všech vyúčtování vyberte nemovitost.</p>
        <div class="more-calc-btn">
            <a class="new-entity-button" href="calculations/<?= $formType;?>">Nové vyúčtování</a>
        </div>

    <?php else:?>

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
                <tr class="row-click" data-href="/applications/<?php /*= $calcURL*/; ?>-calc?calculation_id=<?=$settlement->id;?>">
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
                            'entityId' => $settlement->id,
                            'entityName' => $settlementType->value,
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


    <div id="filter-list" style="display: none">
        <form id="filter_calc_form" method="get" action="calculations">
            <div id="filter-list-content">

            </div>

            <div class="modal_buttons">
                <input type="submit" class="form-btn btn-submit filter-btn" id="" value="Použit">
                <input type="button" class="form-btn btn-reset submit_button_refresh_modal filter-btn" value="Zrušit">
            </div>
        </form>
    </div>

    <?php endif;?>

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
            margin-bottom: -2px; /* перекрывает нижнюю границу контейнера */
            transition: all 0.15s;
        }

        .calc-tab:hover {
            color: #333;
        }

        .calc-tab.is-active {
            color: #000;
            border-bottom-color: #2563eb; /* твой акцентный цвет */
            font-weight: 500;
        }



    </style>


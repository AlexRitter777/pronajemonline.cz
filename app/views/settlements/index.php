
<div class="user-header">
    <h3>Vyúčtování</h3>
</div>

<div class="table-container">

    <div x-data class="calculation-select-type">
        <form method="get" class="calc_type_form" action="calculations">

            <select
                    name="calc_type"
                    class="select-calctype"
                    id="calc-type-list"
                    @change="$el.form.submit()"
            >
                <?php foreach ($settlementTypes as $type => $label): ?>
                    <option value="<?= $type; ?>" ><?= $label; ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <?php if($calculations): ?>
        <table class="calculations-table account-table" border="0">
            <tr class="row-1">
                <th class="col-1">Název</th>
                <th class="col-2">
                    <div class="title-order title-filter">
                        <span>Nemovitost</span>
                        <a class="filter-link" data-filter="property_address" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="9" height="9" viewBox="0 0 256 256" xml:space="preserve">
                                <defs></defs>
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                                    <polygon points="37.29,73.54 45,88.43 52.71,73.54 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                    <polygon points="65.14,49.55 24.86,49.55 32.57,64.44 57.43,64.44 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                    <polygon points="77.57,25.56 12.43,25.56 20.14,40.45 69.86,40.45 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                    <polygon points="82.29,16.46 90,1.57 0,1.57 7.71,16.46 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                </g>
                            </svg>
                        </a>
                    </div>
                </th>
                <th class="col-3">
                    <div class="title-order title-filter">
                        <span>Nájemník</span>
                        <a class="filter-link" data-filter="tenant_name" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="9" height="9" viewBox="0 0 256 256" xml:space="preserve">
                                <defs></defs>
                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                                    <polygon points="37.29,73.54 45,88.43 52.71,73.54 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                    <polygon points="65.14,49.55 24.86,49.55 32.57,64.44 57.43,64.44 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                    <polygon points="77.57,25.56 12.43,25.56 20.14,40.45 69.86,40.45 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                    <polygon points="82.29,16.46 90,1.57 0,1.57 7.71,16.46 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                                </g>
                            </svg>
                        </a>
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


            <?php foreach ($calculations as $calculation): ?>
                <tr class="row-click" data-href="/applications/<?= $calcURL; ?>-calc?calculation_id=<?=$calculation->id;?>">
                    <td class="col-1"><?= $calculation->calculation_name;?></td>
                    <td class="col-2"><?= $calculation->property_address;?></td>
                    <td class="col-3"><?= $calculation->tenant_name;?></td>
                    <?php if($calcType === 'depositcalc'): ?>
                        <td class="col-4"><?= date("d.m.Y", strtotime($calculation->contract_start_date)) . ' - ' . date("d.m.Y", strtotime($calculation->contract_finish_date));?></td>
                    <?php elseif($calcType === 'easyservicescalc'): ?>
                        <td class="col-4"><?= $calculation->rent_year_date; ?></td>
                    <?php elseif($calcType === 'totalcalc'): ?>
                        <td class="col-4">-</td>
                    <?php else: ?>
                        <td class="col-4"><?= date("d.m.Y", strtotime($calculation->rent_start_date)) . ' - ' . date("d.m.Y", strtotime($calculation->rent_finish_date));?></td>
                    <?php endif;?>
                    <td class="col-5"><?= date("d.m.Y", strtotime($calculation->created_at));?></td>
                    <td class="col-6"><?= date("d.m.Y", strtotime($calculation->updated_at));?></td>
                    <td class="col-7 relative">
                        <?=componet('delete-modal-form', [
                            'entityId' => $calculation->id,
                            'entityName' => $calcType,
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

        <div class="more-calc-btn">
            <a class="new-entity-button" href="calculations/<?= $formType;?>">Nové vyúčtování</a>
        </div>
<?php

    //   services-settlements/create
    //   electricity-settlements/create

?>

    <?php else:?>
        <p class="empty-data">Nemáte uložené žádné vyúčtování!</p>
        <div class="more-calc-btn">
            <a class="new-entity-button" href="calculations/<?= $formType;?>">Nové vyúčtování</a>
        </div>
    <?php endif;?>

    <?php //debug($servicesCalculations); ?>

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





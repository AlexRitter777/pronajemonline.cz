<svg style="display: none;">
    <symbol id="minus" viewBox="0 0 32 32">
        <!--icon Minus-->
        <g>
            <path d="M20,17h-8c-0.5522461,0-1-0.4472656-1-1s0.4477539-1,1-1h8c0.5522461,0,1,0.4472656,1,1S20.5522461,17,20,17z" />
        </g>
        <g>
            <path d="M24.71875,29H7.28125C4.9204102,29,3,27.0791016,3,24.71875V7.28125C3,4.9208984,4.9204102,3,7.28125,3h17.4375    C27.0795898,3,29,4.9208984,29,7.28125v17.4375C29,27.0791016,27.0795898,29,24.71875,29z M7.28125,5    C6.0234375,5,5,6.0234375,5,7.28125v17.4375C5,25.9765625,6.0234375,27,7.28125,27h17.4375    C25.9765625,27,27,25.9765625,27,24.71875V7.28125C27,6.0234375,25.9765625,5,24.71875,5H7.28125z" />
        </g>
    </symbol>
</svg>

<div class="user-header">
    <h3>Vyúčtování</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <div class="calculation-select-type">
        <form method="get" class="calc_type_form" action="/user/calculations">
            <!--<label for="calc_type">Druh vyúčtování</label>-->
            <select name="calc_type" class="select-calctype" id="calc-type-list">
                <option value="<?= $calcType; ?>"><?= $calcTypeValue; ?></option>
            </select>
            <!--<input type="submit" class="sbm_calc_type" value="Vybrat">-->
        </form>
    </div>

    <?php if($calculations): ?>
        <table class="calculation-titles account-index-table user-calculations-table" border="0">
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
                            <a href="<?php echo($accountModel->replaceUrlFilterOrder('crt-up'));?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.033" height="5">
                                    <path d="M5.016 0 0 .003 2.506 2.5 5.016 5l2.509-2.5L10.033.003 5.016 0z"/>
                                </svg>
                            </a>
                            <a href="<?php echo($accountModel->replaceUrlFilterOrder('crt-down'));?>">
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
                            <a href="<?php echo($accountModel->replaceUrlFilterOrder('upd-up'));?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10.033" height="5">
                                    <path d="M5.016 0 0 .003 2.506 2.5 5.016 5l2.509-2.5L10.033.003 5.016 0z"/>
                                </svg>
                            </a>
                            <a href="<?php echo($accountModel->replaceUrlFilterOrder('upd-down'));?>">
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
                        <td class="col-4"><?= date("Y", strtotime($calculation->rent_year_date));?></td>
                    <?php elseif($calcType === 'totalcalc'): ?>
                        <td class="col-4">-</td>
                    <?php else: ?>
                        <td class="col-4"><?= date("d.m.Y", strtotime($calculation->rent_start_date)) . ' - ' . date("d.m.Y", strtotime($calculation->rent_finish_date));?></td>
                    <?php endif;?>
                    <td class="col-5"><?= date("d.m.Y", strtotime($calculation->created_at));?></td>
                    <td class="col-6"><?= date("d.m.Y", strtotime($calculation->updated_at));?></td>
                    <td class="col-7"><span class="item_delete_button_ajax" data-type="<?= $calcURL; ?>" data-id="<?=$calculation->id;?>" data-del="#del-conf">Smazat</span></td>

                </tr>
            <?php endforeach;?>
        </table>

        <div class="text-center">
            <?php if($pagination->countPages > 1): ?>
                <?= $pagination; ?>
            <?php endif; ?>
        </div>



    <?php else:?>
        <p class="empty-data">Nemáte uložené žádné vyúčtování!</p>
    <?php endif;?>

    <?php //debug($servicesCalculations); ?>

    <div id="del-conf" class="modal_del_confirmation_ajax">
        <div class="small_modal_wrapper">
            <div><span class="modal_confirm_btn_ajax">Smazat</span></div>
            <div><span class="modal_cancel_btn_ajax">Storno</span></div>
        </div>
    </div>


    <div id="filter-list" style="display: none">
        <form id="filter_calc_form" action="">
            <div id="filter-list-content">

            </div>

            <div class="modal_buttons">
                <input type="submit" class="submit_button submit_button_modal recaptcha" id="" value="Použit">
                <button type="button" class="submit_button_refresh submit_button_refresh_modal">Zrušit</button>
            </div>
        </form>
    </div>





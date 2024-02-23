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
<svg style="display: none;">
    <symbol id="plus" viewBox="0 0 96 96">
        <!--icon Plus-->
        <g>
            <path d="M80,4H16C9.37,4,4,9.37,4,16v64c0,6.63,5.37,12,12,12h64c6.63,0,12-5.37,12-12V16C92,9.37,86.63,4,80,4z M84,80  c0,2.21-1.79,4-4,4H16c-2.21,0-4-1.79-4-4V16c0-2.21,1.79-4,4-4h64c2.21,0,4,1.79,4,4V80z" />
            <path d="M64,44H52V32c0-2.209-1.791-4-4-4s-4,1.791-4,4v12H32c-2.209,0-4,1.791-4,4s1.791,4,4,4h12v12c0,2.209,1.791,4,4,4  s4-1.791,4-4V52h12c2.209,0,4-1.791,4-4S66.209,44,64,44z" />
        </g>
    </symbol>
</svg>
<svg style="display:none;">
    <!--icon Help-->
    <symbol id="help" viewBox="0 0 24 24">
        <g>
            <path d="M0 0h24v24H0z" fill="none" />
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
        </g>
    </symbol>
</svg>



<div class="container">
    <h1 class="title">Zjednodušené vyúčtování služeb spojených s užíváním bytu </h1>
    <form method="POST" class="form" name="easyservices" action="/applications/services-calc">

        <?php require_once APP . "/views/Includes/common_calc_data.php"; ?>


        <h2 class="subtitle">IV. Správce </h2>

        <label for="adminName" class="label_text">Název firmy, vykonávající správu domu</label><br />
        <?php if(is_user_logged_in()): ?>
            <select name="adminName" id="adminName" class="field-1 select-admin select-ajax input-admin-list" data-entity="admin">
                <option value="<?= $data['adminName'];?>"><?= $data['adminName'];?></option>
            </select><br />
        <?php else: ?>
            <input type="text" name="adminName" id="adminName" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['adminName'] ?>"><br />
        <?php endif;?>
        <h2 class="subtitle">V. Vyúčtování za období</h2>

        <div class="text-help">
            <h3 class="h3-subtitle">Vyúčtování zpracováno za období:</h3>
            <svg class="icon_help help-right-text" data-hint="#real-hint-3">
                <use xlink: href="#help"></use>
            </svg>
        </div>

        <div class="origins">
            <label class="label_text">Období, za které se zpracovává vyúčtovaní *</label>
            <select name="rentYearDate" class="select-list-rent-date-year" id="rentYearDate" style="width: 32.5%">
                <option value="<?= $data['rentYearDate'];?>"><?= $data['rentYearDate'];?></option>
            </select>
        </div>

        <h2 class="subtitle">VI. Náklady za období </h2>

        <div class="text-help">
            <label class="label_text" id="label_text">Vyberte náklad a zadejte částku *</label><br />
            <svg class="icon_help help-right-text" data-hint="#real-hint-4">
                <use xlink: href="#help"></use>
            </svg>
        </div>

        <div class="add_input_fields">
            <div class="add_field first-field">
                <select name="pausalniNaklad[]" class="select-list" id="test1" style="width: 55%">
                    <option value="<?=$data['pausalniNaklad'][0]; ?>"><?=$data['pausalniNaklad'][0]; ?></option>
                </select>
                <input type="number" class="right-field" name="servicesCost[]" id="servicesCost1" step="any" placeholder="Zadej častku v Kč" value="<?=$data['servicesCost'][0] ?>" />
            </div>
            <!-- /.add_field first-field-->
            <?php if(isset($data['pausalniNaklad'])): ?>
                <?php for ($i = 1; $i <= count($data['pausalniNaklad']); $i++):?>
                    <?php if(!empty($data['pausalniNaklad'][$i])): ?>

                        <div class="add_field costs_added_after" id="<?= ($i+1)?>">
                            <select name="pausalniNaklad[]" class="added-content select-list" id="test<?= ($i+1)?>" style="width: 55%">
                                <option value="<?=$data['pausalniNaklad'][$i]; ?>"><?=$data['pausalniNaklad'][$i]; ?></option>
                            </select>
                            <input type="number" class="right-field" name="servicesCost[]" id="servicesCost<?= ($i+1)?>" step="any" placeholder="Zadej častku v Kč" value="<?=$data['servicesCost'][$i]; ?>"/>
                            <a href="#" class="remove_field">
                                <svg class="icon_minus">
                                    <use xlink: href = "#minus" ></use >
                                </svg >
                                <span class = "icon_title">Odebrat</span>
                            </a>
                        </div>
                        <!-- /.add_field costs_added_after -->
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
        <!-- /.add_input_fields -->

        <a href="#" class="add_input_fields_button">
            <svg class="icon_plus">
                <use xlink: href="#plus"></use>
            </svg>
            <span class="icon_title">Přidat náklad</span>
        </a>


        <h2 class="subtitle">VII. Uhrazené zálohy</h2>

        <div class="zalohy">
            <div class="zalohy_label">
                <label for="advancedPayments" class="label_text">Součet zaloh za služby, zaplacených najmeníkem v ramcích učtovácího období</label>
            </div>
            <input type="number" class="field field-slozky" id="advancedPayments" name="advancedPayments" step="any" placeholder="Zadej součet záloh" value="<?= $data['advancedPayments']; ?>" />
        </div>

        <label for="advancedPaymentsDesc" class="label_text">Uhrazené zálohy – komentář </label><br />
        <input type="text" name="advancedPaymentsDesc" id="advancedPaymentsDesc" class="field-1" maxlength="75" placeholder="Např. Leden 2020 - Červen 2020 - 2000 Kč" value="<?=$data['advancedPaymentsDesc']?>"><br />

        <div class="errors_field">

        </div>

        <div class="submit_button_div">
            <input type="button" class="submit_button_refresh" id="btn_clear" value="Očistit" />
            <input type="submit" class="submit_button" id="btn_submit" value="Odeslat" />
        </div>
        <input type="hidden" name="calculationName" value="<?= $data['calculationName'] ?? '';?>">
        <input type="hidden" name="id" value="<?= $data['calculationId'] ?? '';?>">

    </form>
</div>

<?php require_once APP . "/views/Short_hints/easyservices_hints.php"; ?>


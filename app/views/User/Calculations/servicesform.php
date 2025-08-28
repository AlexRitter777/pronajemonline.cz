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

<?php //debug($data);?>

<div class="main-container">

    <h1 class="title">Vyúčtování služeb spojených s užíváním bytu </h1>

    <form method="POST" class="form calculation-form" name="services">

        <?php require_once APP . "/views/Includes/common_calc_data.php"; ?>

        <!--Správce-->
        <div class="form-admin-group">
            <h2 class="calculation-title">IV. Správce </h2>

            <label for="adminName" class="label_text">Název firmy, vykonávající správu domu</label>
            <?php if(is_user_logged_in()): ?>
            <div class="select-wrapper">
                <select name="adminName" id="adminName" class="field-1 select-admin select-ajax input-admin-list" data-entity="admin">
                    <option value="<?= $data['adminName'] ?? '';?>"><?= $data['adminName'] ?? '';?></option>
                </select>
            </div>
            <?php else: ?>
                <input type="text" name="adminName" id="adminName" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['adminName'] ?? '' ?>">
            <?php endif;?>
        </div>
        <!--End Správce-->

        <!--Období-->
        <div class="form-dates-group">
            <h2 class="calculation-title">V. Vyúčtování za období</h2>

            <div class="text-help">
                <h3 class="calculation-subtitle">Vyúčtování správce zpracováno za období:</h3>
                <svg class="icon_help help-right-text" data-hint="#real-hint-2">
                    <use xlink: href="#help"></use>
                </svg>
            </div>

            <div class="date">
                <label for="calcStartDate" class="label_text">Počáteční datum vyúčtování správce *</label>
                <input type="date" class="field-start-date" name="calcStartDate" id="calcStartDate" value="<?=$data['calcStartDate'] ?? ''; ?>">
            </div>
            <div class="date">
                <label for="calcFinishDate" class="label_text">Konečný datum vyúčtování správce *</label>
                <input type="date" class="field-finish-date" name="calcFinishDate" id="calcFinishDate" value="<?=$data['calcFinishDate'] ?? '';?>">
            </div>

            <div class="text-help">
                <h3 class="calculation-subtitle">Vyúčtování pronajímatele zpracováno za období:</h3>
                <svg class="icon_help help-right-text" data-hint="#real-hint-3">
                    <use xlink: href="#help"></use>
                </svg>
            </div>
            <div class="date">
                <label for="rentStartDate" class="label_text">Počáteční datum vyúčtování pronajímatele *</label>
                <input type="date" name="rentStartDate" class="field-start-rent" id="rentStartDate" class="field" value="<?= $data['rentStartDate'] ?? '';?>">
            </div>
            <div class="date">
                <label for="rentFinishDate" class="label_text">Konečný datum vyúčtování pronajímatele *</label>
                <input type="date" name="rentFinishDate" class="field-finish-rent" id="rentFinishDate" class="field" value="<?= $data['rentFinishDate'] ?? '';?>">
            </div>
        </div>
        <!--End Období-->


        <!--Náklady na služby a správu domu-->
        <div class="form-service-charges-group">
            <h2 class="calculation-title">VI. Náklady na služby a správu domu </h2>

            <label class="label_text text-help" id="label_text">
                <span>Vyberte náklad a zadejte částku *</span>
                <svg class="icon_help help-right-text" data-hint="#real-hint-4">
                    <use xlink: href="#help"></use>
                </svg>
            </label>

            <div class="add_input_fields">
                <div class="add_field first-field">
                    <select name="pausalniNaklad[]" class="select-list" id="test1" style="width: 55%">
                        <option value="<?=$data['pausalniNaklad'][0] ?? ''; ?>"><?=$data['pausalniNaklad'][0] ?? ''; ?></option>
                    </select>
                    <input type="number" class="right-field" name="servicesCost[]" id="servicesCost1" step="any" placeholder="Zadej částku v Kč" value="<?=$data['servicesCost'][0] ?? ''; ?>" />
                </div>
                <!-- /.add_field first-field-->
                <?php if(isset($data['pausalniNaklad'])):?>
                    <?php for ($i = 1; $i <= count($data['pausalniNaklad']); $i++):?>
                        <?php if(!empty($data['pausalniNaklad'][$i])): ?>

                            <div class="add_field costs_added_after" id="<?= ($i+1)?>">
                                <select name="pausalniNaklad[]" class="added-content select-list" id="test<?= ($i+1)?>" style="width: 55%">
                                    <option value="<?=$data['pausalniNaklad'][$i]; ?>"><?=$data['pausalniNaklad'][$i]; ?></option>
                                </select>
                                <input type="number" class="right-field" name="servicesCost[]" id="servicesCost<?= ($i+1)?>" step="any" placeholder="Zadej částku v Kč" value="<?=$data['servicesCost'][$i]; ?>"/>
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
        </div>
        <!--End Náklady na služby a správu domu-->

        <!--Měřidla-->
        <div class="form-meters-group">
            <h2 class="calculation-title">VII. Odečty měřidel</h2>

            <label class="label_text text-help" id="label_text">
                <span>Zadejte druhy, stavy a čísla měřidel. *</span>
                <svg class="icon_help help-right-text" data-hint="#real-hint-5">
                    <use xlink: href="#help"></use>
                </svg>
            </label>


            <div class="add_meters">
                <div class="add_meters_added_field first-field">
                    <select name="appMeters[]" class="select-list-meters" id="load_php_meters1" style="width: 21%">
                        <option value="<?= $data['appMeters'][0] ?? ''; ?>"><?= $data['appMeters'][0] ?? ''; ?></option>
                    </select>
<!--                    <div class="meters-values-wrapper">-->
                        <input type="number" class="field right-field" name="initialValue[]" id="initialValue1" step="any" placeholder="Počáteční stav" style="width: 16%" value="<?= $data['initialValue'][0] ?? ''; ?>" />
                        <input type="number" class="field last-field" name="endValue[]" id="endValue1" step="any" placeholder="Konečný stav" style="width: 16%" value="<?= $data['endValue'][0] ?? ''; ?>" />
<!--                    </div>-->
                    <input type="text" class="field last-field" name="meterNumber[]" id="meterNumber1" placeholder="Číslo měřidla" style="width: 27%" value="<?= $data['meterNumber'][0] ?? ''; ?>" />
                </div>
                <!-- /.add_meters_added_field first-field -->

                <?php if(isset($data['appMeters'])): ?>
                    <?php for ($i = 1; $i <= count($data['appMeters']); $i++):?>
                        <?php if(!empty($data['appMeters'][$i])): ?>
                            <div class="add_meters_added_field meters_added_after" id="<?= ($i+1)?>">
                                <select name="appMeters[]" class="added-content-meters select-list" id="load_php_meters<?=($i+1)?>" style="width: 21%">
                                    <option value="<?= $data['appMeters'][$i]?>"><?= $data['appMeters'][$i]?></option>
                                </select>
                                <input type="number" class="field right-field" name="initialValue[]" id="initialValue<?= ($i+1)?>" step="any" placeholder="Počáteční stav" style="width: 16%" value="<?= $data['initialValue'][$i]?>"/>
                                <input type="number" class="field last-field" name="endValue[]" id="endValue<?= ($i+1)?>" step="any" placeholder="Konečný stav" style="width: 16%" value="<?= $data['endValue'][$i]?>"/>
                                <input type="text" class="field last-field" name="meterNumber[]" id="meterNumber<?= ($i+1)?>" placeholder="Číslo měřidla" style="width: 27%" value="<?= $data['meterNumber'][$i]?>"/>
                                <a href="#" class="remove_meters">
                                    <svg class="icon_minus">
                                        <use xlink: href = "#minus" ></use >
                                    </svg >
                                    <span class = "icon_title">Odebrat</span>
                                </a>
                            </div>
                            <!-- /.add_meters_added_field meters_added_after -->
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
            <!-- /.add_meters -->

            <a href="#" class="add_meters_button">
                <svg class="icon_plus">
                    <use xlink: href="#plus"></use>
                </svg>
                <span class="icon_title">Přidat měřidlo</span>
            </a>

            <div class="text-help">
                <label class="label_text" id="label_text">Vyberte zdroj odečtů měřidel z uvedených možností</label>
            </div>

            <div class="origins">
                <label class="label_text">Zdroj počátečních stavů měřidel </label>
                <select name="originMeterStart" class="select-list-origin-start" id="load_php_origin_start" style="width: 32.5%;">
                    <option value="<?= $data['originMeterStart'] ?? ''; ?>"><?= $data['originMeterStart'] ?? ''; ?></option>
                </select>
            </div>
            <div class="origins">
                <label class="label_text">Zdroj konečných stavů měřidel</label>
                <select name="originMeterEnd" class="select-list-origin-end" id="load_php_origin_end" style="width: 32.5%">
                    <option value="<?= $data['originMeterEnd'] ?? ''; ?>"><?= $data['originMeterEnd'] ?? ''; ?></option>
                </select>
            </div>


            <div class="coefficient_label_text text-help">
                <label class="label_text" id="label_text">
                    Byly ve vyúčtování od správce použity koeficienty pro výpočet spotřeby ústředního topení?
                </label>
                <svg class="icon_help help-right-text" data-hint="#real-hint-6">
                    <use xlink: href="#help"></use>
                </svg>
            </div>


            <div class="chekbox_coefficient">
                <label class="label_text" for="ano_coefficient">Ano</label>
                <input type="radio" id="ano_coefficient" name="coefficient" value="Ano">
            </div>
            <div class="chekbox_coefficient">
                <label class="label_text" for="ne_coefficient">Ne</label>
                <input type="radio" id="ne_coefficient" name="coefficient" value="Ne">
            </div>
            <div class="coefficient">

                <?php if(!empty($data['coefficientValue'][0])): ?>

                    <div class = "add_coefficient">
                        <div class="add_coefficient_field">
                            <input type = "number" class = "coefficient_field" id = "coefficientValue1" name = "coefficientValue[]" step = "any" placeholder = "Zadej koeficient" value="<?=$data['coefficientValue'][0] ?>"/><br/>


                            <?php for ($i = 1; $i <= count($data['coefficientValue']); $i++):?>
                                <?php if (!empty($data['coefficientValue'][$i])): ?>
                                    <div class = "coefficient_added_field" id="<?= ($i+1); ?>">
                                        <input type="number" class="coefficient_field added_coefficient_field" id="coefficientValue<?= ($i + 1); ?>" name="coefficientValue[]" step="any" placeholder="Zadej koeficient" value="<?= $data['coefficientValue'][$i]?>" />
                                        <a href="#" class="remove_coefficients">
                                            <svg class="icon_minus">
                                                <use xlink: href = "#minus" ></use >
                                            </svg ><span class = "icon_title">Odebrat</span>
                                        </a>
                                    </div>
                                    <!-- /.coefficient_added_field -->
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <!-- /.add_coefficient_field -->
                        <a href="#" class="add_coefficient_button">
                            <svg class="icon_plus">
                                <use xlink: href = "#plus"></use>
                            </svg>
                            <span class="icon_title">Přidat koeficient</span>
                        </a>
                    </div>
                    <!-- /.add_coefficient -->
                <?php endif; ?>

            </div>
            <!-- /.coefficient -->
        </div>
        <!--End Měřidla-->



        <!--Ceny-->
        <div class="form-prices-group">
            <h2 class="calculation-title">VIII. Ceny energií</h2>

            <div class="text-help">
                <label class="label_text" id="label_text"><i>Ceny zadávejte jen tehdy, pokud byly vybrány odpovídající měřidla v části VII</i></label>
            </div>

            <div class="text-help" style="align-items:center;">
                <h3 class="zakladni_slozka_title">Základní složka</h3>
                <svg class="icon_help help-right-text" style="margin-top: 0px" data-hint="#real-hint-7">
                    <use xlink: href="#help"></use>
                </svg>
            </div>


            <div class="zakladni_slozka">
                <label for="constHotWaterPrice" class="label_text">Základní složka za ohřev teplé užitkové vody(TUV)</label>
                <input type="number" class="field field-slozky" id="constHotWaterPrice" name="constHotWaterPrice" step="any" placeholder="Zadej cenu" value="<?= $data['constHotWaterPrice'] ?? '';?>" />
            </div>

            <div class="zakladni_slozka">
                <label for="constHeatingPrice" class="label_text">Základní složka za ústřední topení (UT)</label>
                <input type="number" class="field field-slozky" id="constHeatingPrice" name="constHeatingPrice" step="any" placeholder="Zadej cenu" value="<?= $data['constHeatingPrice'] ?? ''; ?>" />
            </div>

            <div class="text-help" style="align-items:center;">
                <h3 class="spotrebni_slozka_title">Spotřební složka</h3>
                <svg class="icon_help help-right-text" style="margin-top:10px" data-hint="#real-hint-8">
                    <use xlink: href="#help"></use>
                </svg>
            </div>

            <div class="spotrebni_slozka">
                <label for="hotWaterPrice" class="label_text">Cena za ohřev 1 m3 teplé užitkové vody (TUV)</label>
                <input type="number" class="field field-slozky" id="hotWaterPrice" name="hotWaterPrice" step="any" placeholder="Zadej cenu jednotky" value="<?= $data['hotWaterPrice'] ?? '';?>" />
            </div>

            <div class="spotrebni_slozka">
                <label for="coldWaterPrice" class="label_text">Cena za 1 m3 studené užitkové vody (SUV)</label>
                <input type="number" class="field field-slozky" id="coldWaterPrice" name="coldWaterPrice" step="any" placeholder="Zadej cenu jednotky" value="<?= $data['coldWaterPrice'] ?? ''; ?>" />
            </div>

            <div class="spotrebni_slozka" style="margin-bottom: 15px;">
                <label for="coldForHotWaterPrice" class="label_text label_text_with_help">
                    Cena 1 m3 studené užitkové vody, použité pro přípravu teplé užitkové vody (SUV pro TUV)
                </label>
                <svg class="icon_help help-right-label" data-hint="#real-hint-9">
                    <use xlink: href="#help"></use>
                </svg>
                <input type="number" class="field field-slozky" id="coldForHotWaterPrice" name="coldForHotWaterPrice" step="any" placeholder="Zadej cenu jednotky" value="<?= $data['coldForHotWaterPrice'] ?? ''; ?>" />
            </div>

            <div class="coefficient_label_text text-help">
                <label class="label_text" id="label_text" >
                    <span>Byla ve vyúčtování správce použita korigovaná hodnota spotřební složky?</span><br>
                </label>
                <svg class="icon_help help-right-text" data-hint="#real-hint-10">
                    <use xlink: href="#help"></use>
                </svg>
            </div>

            <div class="chekbox_coefficient">
                <label class="label_text" for="changedHeatingCostsYes">Ano</label>
                <input type="radio" id="changedHeatingCostsYes" name="changedHeatingCostsButton" value="Ano">
            </div>
            <div class="chekbox_coefficient">
                <label class="label_text" for="changedHeatingCostsNo">Ne</label>
                <input type="radio" id="changedHeatingCostsNo" name="changedHeatingCostsButton" value="Ne">
            </div>
            <div class="changed_heating">
                <?php if (isset($data['changedHeatingCosts'])):?>
                    <div class="spotrebni_slozka">
                        <label for="changedHeatingCosts" class="label_text">Celkové náklady na korigovanou spotřební složku</label>
                        <input type="number" class="field field-slozky" id="changedHeatingCosts" name="changedHeatingCosts" step="any" placeholder="Zadej celkovou cenu" value="<?= $data['changedHeatingCosts']; ?>" />
                    </div>
                    <div class="spotrebni_slozka">
                        <label for="heatingYearSum" class="label_text">Spotřeba tepla za období vyúčtování správce</label>
                        <input type="number" class="field field-slozky" id="heatingYearSum" name="heatingYearSum" step="any" placeholder="Zadej celkovou spotřebu" value="<?= $data['heatingYearSum']; ?>" />
                    </div>
                <?php endif;?>
            </div>
            <div class="spotrebni_slozka" id="spotrebni_slozka_heating">
                <?php if (!isset($data['changedHeatingCosts'])):?>
                <label for="heatingPrice" class="label_text">Cena za jednotku ústředního topení (UT)</label>
                <input type="number" class="field field-slozky" id="heatingPrice" name="heatingPrice" step="any" placeholder="Zadej cenu jednotky" value="<?= $data['heatingPrice'] ?? ''; ?>" />
                <?php endif;?>
            </div>
        </div>
        <!--End Ceny-->

        <!--Korekce-->
        <div class="form-adjustment-group">
            <h2 class="calculation-title">IX. Korekce cen pro aktuální zúčtovací období </h2>
            <div class="coefficient_label_text text-help">
                <label class="label_text" id="label_text">
                    <span>Potřebujete navýšit/snížit ceny služeb nebo energií pro aktuální</span><br>
                    <span>zúčtovací období?</span>
                </label>
                <svg class="icon_help help-right-text" data-hint="#real-hint-11">
                    <use xlink: href="#help"></use>
                </svg>
            </div>

            <div class="chekbox_coefficient">
                <label class="label_text" for="costCorrectionYes">Ano</label>
                <input type="radio" id="costCorrectionYes" name="costCorrection" value="Ano">
            </div>
            <div class="chekbox_coefficient">
                <label class="label_text" for="costCorrectionNo">Ne</label>
                <input type="radio" id="costCorrectionNo" name="costCorrection" value="Ne">
            </div>
            <div class="correction">
                <?php if (isset($data['servicesCostCorrection']) || isset($data['hotWaterCorrection']) || isset($data['heatingCorrection']) || isset($data['coldWaterCorrection'])): ?>
                <div class="korekce">
                    <label for="servicesCostCorrection" class="label_text">Odhadovaná průměrná změna cen služeb a správy domu</label>
                    <input type="number" class="field field-slozky" id="servicesCostCorrection" name="servicesCostCorrection" step="any" placeholder="Zadej %" value="<?= $data['servicesCostCorrection']?>" />
                </div>
                <div class="korekce">
                    <label for="hotWaterCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na TUV</label>
                    <input type="number" class="field field-slozky" id="hotWaterCorrection" name="hotWaterCorrection" step="any" placeholder="Zadej %" value="<?= $data['hotWaterCorrection']?>" />
                </div>
                <div class="korekce">
                    <label for="heatingCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na UT</label>
                    <input type="number" class="field field-slozky" id="heatingCorrection" name="heatingCorrection" step="any" placeholder="Zadej %" value="<?= $data['heatingCorrection']?>" />
                </div>
                <div class="korekce">
                    <label for="coldWaterCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na SUV</label>
                    <input type="number" class="field field-slozky" id="coldWaterCorrection" name="coldWaterCorrection" step="any" placeholder="Zadej %" value="<?=$data['coldWaterCorrection'] ?>" />
                </div>
                <?php endif;?>
            </div>
        </div>
        <!-- End Korekce-->

        <!--Zálohy-->
        <div class="form-adv-payments-group">
            <h2 class="calculation-title">X. Uhrazené zálohy</h2>

            <div class="zalohy">
                <div class="zalohy_label">
                    <label for="advancedPayments" class="label_text">Součet záloh na služby zaplacených nájemníkem za účtovací období</label>
                </div>
                <input type="number" class="field field-slozky" id="advancedPayments" name="advancedPayments" step="any" placeholder="Zadej součet záloh" value="<?= $data['advancedPayments'] ?? ''; ?>" />
            </div>

            <label for="advancedPaymentsDesc" class="label_text">Uhrazené zálohy – poznámka </label><br />
            <input type="text" name="advancedPaymentsDesc" id="advancedPaymentsDesc" class="field-1" maxlength="75" placeholder="Např. Leden 2020 - Červen 2020 - 2000 Kč" value="<?=$data['advancedPaymentsDesc'] ?? '';?>"><br />
        </div>
        <!--End Zálohy-->

        <!--Validation errors-->
        <div class="errors_field">

        </div>
        <!--End Validation errors-->

        <!--Buttons-->
        <div class="submit_button_div">
            <input type="submit" class="form-btn btn-submit btn-calc-submit" id="btn_submit" value="Spočítat" />
            <input type="button" class="form-btn btn-reset" id="btn_clear" value="Vymazat" />
        </div>
        <!--End Buttons-->

        <input type="hidden" name="calculationName" value="<?= $data['calculationName'] ?? '';?>">
        <input type="hidden" name="id" value="<?= $data['calculationId'] ?? '';?>">
    </form>
</div>

<?php require_once APP . "/views/Short_hints/services_hints.php"; ?>

<template id="admin-modal">
    <?php include APP . '/views/modal_templates/admin.php'; ?>
</template>

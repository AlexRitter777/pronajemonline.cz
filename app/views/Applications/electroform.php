<svg style="display:none;">
    <!--Icon Help-->
    <symbol id="help" viewBox="0 0 24 24">
        <g>
            <path d="M0 0h24v24H0z" fill="none" />
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
        </g>
    </symbol>
</svg>
<div class="container">
    <h1 class="title">Vyúčtování spotřeby elektřiny</h1>
    <form method="POST" class="form calc-form" action="/applications/electro-calc" name="electro">

        <?php require_once APP . "/views/Includes/common_calc_data.php"; ?>

        <h2 class="subtitle">IV. Dodavatel elektřiny </h2>

        <label for="supplierName" class="label_text">Název firmy – dodavatele elektřiny</label><br />
        <?php if(is_user_logged_in()): ?>
            <select name="supplierName" id="supplierName" class="field-1 select-elsupplier select-ajax input-elsupplier-list" data-entity="elsupplier">
                <option value="<?= $data['supplierName'];?>"><?= $data['supplierName'];?></option>
            </select><br />
        <?php else: ?>
            <input type="text" name="supplierName" id="supplierName" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['supplierName'];?>"><br />
        <?php endif;?>

        <h2 class="subtitle">V. Vyúčtování za období</h2>

        <div class="text-help">
            <h3 class="h3-subtitle">Vyúčtování spotřeby elektřiny zpracováno za období:</h3>
            <svg class="icon_help help-right-text" data-hint="#real-hint-2">
                <use xlink: href="#help"></use>
            </svg>
        </div>
        <div class="date">
            <label for="rentStartDate" class="label_text">Počáteční datum vyúčtování*</label><br />
            <input type="date" name="rentStartDate" class="field-start-electro" id="rentStartDate" class="field" value="<?= $data['rentStartDate'];?>"><br />
        </div>
        <div class="date">
            <label for="rentFinishDate" class="label_text">Konečný datum vyúčtování*</label><br />
            <input type="date" name="rentFinishDate" class="field-finish-electro" id="rentFinishDate" class="field" value="<?= $data['rentFinishDate'];?>"><br />
        </div>

        <h2 class="subtitle">VI. Odečty elektroměru </h2>

        <div class="text-help">
            <label class="label_text" id="label_text">Zadejte počáteční a konečný stavy v kWh *</label><br />
            <svg class="icon_help help-right-text" data-hint="#real-hint-3">
                <use xlink: href="#help"></use>
            </svg>
        </div>

        <div class="meters-electro">
            <input type="number" class="field meter-electro-field" name="initialValueOne" id="initialValueOne" step="any" placeholder="Počáteční stav" value="<?= $data['initialValueOne'];?>" />
            <input type="number" class="field meter-electro-field" name="endValueOne" id="endValueOne" step="any" placeholder="Koneční stav" value="<?= $data['endValueOne'];?>" />
            <input type="text" class="field meter-electro-field" name="meterNumberOne" id="meterNumberOne" placeholder="Číslo elektroměru" value="<?= $data['meterNumberOne'];?>" />
        </div>

        <div class="text-help">
            <label class="label_text" id="label_text">Vyber z uvedených možností zdroje odečtů elektroměru</label>
        </div>
        <div class="origins">
            <label class="label_text">Zdroj počátečního stavu elektroměru </label>
            <select name="originMeterStart" class="select-list-origin-electro-start" id="load_php_origin_electro_start" style="width: 32.5%">
                <option value="<?= $data['originMeterStart'];?>"><?= $data['originMeterStart'];?></option>
            </select>
        </div>
        <div class="origins">
            <label class="label_text">Zdroj konečného stavu měřičů </label>
            <select name="originMeterEnd" class="select-list-origin-electro-end" id="load_php_origin_electro_end" style="width: 32.5%">
                <option value="<?= $data['originMeterEnd'];?>"><?= $data['originMeterEnd'];?></option>
            </select>
        </div>

        <h2 class="subtitle">VII. Ceny elektřiny </h2>

        <div class="text-help" style="align-items:center;">
            <div class="text-help">
                <label class="label_text" id="label_text">Zadejte průměrné jednotkové ceny z faktury za elektřinu nebo z ceníku  </label>
            </div>
        </div>


        <div class="cena_electro">
            <label for="electroPriceKWh" class="label_text">Průměrná jednotková cena za kWh</label>
            <input type="number" class="field field-ceny-electro" id="electroPriceKWh" name="electroPriceKWh" step="any" placeholder="Zadej cenu" value="<?= $data['electroPriceKWh'];?>" />
        </div>

        <div class="cena_electro">
            <label for="electroPriceMonth" class="label_text">Průměrná jednotková cena za měsíc </label>
            <input type="number" class="field field-ceny-electro" id="electroPriceMonth" name="electroPriceMonth" step="any" placeholder="Zadej cenu" value="<?= $data['electroPriceMonth'];?>" />
        </div>

        <div class="cena_electro">
            <label for="electroPriceAdd" class="label_text">Jiné náklady (nepovinné)
                <svg class="icon_help" data-hint="#real-hint-4">
                    <use xlink: href="#help"></use>
                </svg>
            </label>

            <input type="number" class="field field-ceny-electro" id="electroPriceAdd" name="electroPriceAdd" step="any" placeholder="Zadej častku" value="<?= $data['electroPriceAdd'];?>" />
        </div>

        <label for="electroPriceAddDesc" class="label_text">Jiné náklady - popis (nepovinné) </label><br />
        <input type="text" name="electroPriceAddDesc" id="electroPriceAddDesc" class="field-1" maxlength="75"  value="<?=$data['electroPriceAddDesc']?>"><br />

        <h2 class="subtitle">VIII. Uhrazené zálohy</h2>

        <div class="zalohy_electro">
            <div class="zalohy_electro_label">
                <label for="advancedPayments" class="label_text">Součet záloh za elektřinu, zaplacených nájemníkem v rámcích účtovacího období*</label>
            </div>
            <input type="number" class="field field-ceny-electro" id="advancedPayments" name="advancedPayments" step="any" placeholder="Zadej coučet záloh" value="<?= $data['advancedPayments'];?>" />
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

<?php require_once APP . "/views/Short_hints/electro_hints.php"; ?>
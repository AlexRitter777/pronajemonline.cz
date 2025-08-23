<?php  //debug($result); ?>
<div class="main-title">
    <h1 class="title">Vyúčtování služeb spojených s užíváním bytu za období<br>
        <?= date("d.m.Y", strtotime($result['rentStartDate'])) . ' - ' . date("d.m.Y", strtotime($result['rentFinishDate'])) ?>
    </h1>
</div>

<div class="personal-left">
    <h3 class="sub-subtitle">Pronajímatel:</h3>
    <span>
            <?= $result['landlordName']; ?>
        </span><br>
    <span>
            <?= $result['landlordAddress']; ?>
        </span><br>
</div>
<div class="personal-right">
    <h3 class="sub-subtitle">Nájemník:</h3>
    <span>
            <?= $result['tenantName']; ?>
        </span><br>
    <span>
            <?= $result['tenantAddress']; ?>
        </span><br>
</div>

<div class="property-left">
    <h3 class="sub-subtitle">Adresa nemovitosti:</h3>
    <span>
            <?= $result['propertyAddress']; ?>
        </span>
</div>
<div class="property-right">
    <h3 class="sub-subtitle">Druh nemovitosti:</h3>
    <span>
            <?= $result['propertyType']; ?>
        </span>
</div>

<div class="admin-text">
    <h3 class="sub-subtitle">Správce domu:</h3>
    <span>
            <?= !empty($result['adminName']) ? $result['adminName'] : 'Neuvedeno' ?>
        </span>
</div>

<table class="dates" border="0">
    <tr>
        <td class="col-1">Období vyúčtování</td>
        <td class="col-2"><?= date("d.m.Y", strtotime($result['rentStartDate'])); ?></td>
        <td class="col-3"><?= date("d.m.Y", strtotime($result['rentFinishDate'])); ?></td>
        <td class="col-4"><?= $result['rentDifMonth']; ?> měs</td>
        <td class="col-5"></td>
    </tr>
</table>

<table class="dates" border="0">
    <tr>
        <td class="col-1">Období vyúčtování správce</td>
        <td class="col-2"><?= date("d.m.Y", strtotime($result['calcStartDate'])); ?></td>
        <td class="col-3"><?= date("d.m.Y", strtotime($result['calcFinishDate'])); ?></td>
        <td class="col-4"><?= $result['calcDifMonth']; ?> měs</td>
        <td class="col-5"></td>
    </tr>
</table>

<h2 class="subtitle">I. Odečty měřících přístrojů</h2>
<table class="meters-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Media</td>
        <td class="col-2">Výrobní číslo</td>
        <td class="col-3">Počat. stav</td>
        <td class="col-4">Koneč. stav</td>
        <td class="col-5">Rozdíl náměr.</td>
        <td class="col-6">Součin koeficientů</td>
        <td class="col-7">Náměr pro výpočet</td>
    </tr>
</table>

<?php for ($i=0; $i<count($result['appMeters']); $i++): ?>

    <table class="meters-rows" border="0">
        <tr class="row-<?= ($i+2);?>">
            <td class="col-1"><?= $result['appMeters'][$i] ?></td>
            <td class="col-2"><?= $result['meterNumber'][$i] ?></td>
            <td class="col-3"><?= $result['initialValue'][$i] ?></td>
            <td class="col-4"><?= $result['endValue'][$i] ?></td>
            <td class="col-5"><?= $result['diffMetersValues']['noCoeff'][$i] ?></td>
            <td class="col-6"><?= $result['diffMetersValues']['coeffView'][$i] ?></td>
            <td class="col-7"><?= $result['diffMetersValues']['final'][$i] ?></td>
        </tr>
    </table>

<?php endfor;?>

<table class="meters-row-origins-1" border="0">
    <tr class="row-1">
        <td class="col-1">Zdroj odečtů počátečních stavů:</td>
        <td class="col-2"><?= !empty($result['originMeterStart']) ? $result['originMeterStart'] : 'Neuvedeno' ?></td>
    </tr>
</table>

<table class="meters-row-origins-2" border="0">
    <tr class="row-1">
        <td class="col-1">Zdroj odečtů konečných stavů:</td>
        <td class="col-2"><?= !empty($result['originMeterEnd']) ? $result['originMeterEnd'] : 'Neuvedeno'?></td>
    </tr>
</table>

<table class="meters-total-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Souhrnné odečty</td>
    </tr>
</table>

<table class="meters-total-row-2" border="0">
    <tr class="row-1">
        <td class="col-1">Teplá užitková voda (TUV), m3</td>
        <td class="col-2"><?= !empty($result['hotWaterSum']) ? $result['hotWaterSum'] : '-' ?></td>
    </tr>
</table>

<table class="meters-total-row-3" border="0">
    <tr class="row-1">
        <td class="col-1">Studená užitková voda (SUV), m3</td>
        <td class="col-2"><?= !empty($result['coldWaterSum']) ? $result['coldWaterSum'] : '-' ?></td>
    </tr>
</table>

<table class="meters-total-row-4" border="0">
    <tr class="row-1">
        <td class="col-1">Ústřední topení (UT), jedn.</td>
        <td class="col-2"><?= !empty($result['heatingSum']) ? $result['heatingSum'] : '-' ?></td>
    </tr>
</table>


<h2 class="subtitle">II. Paušální náklady</h2>

<table class="services-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Náklady za období, Kč<br>(<?= $result['calcDifMonth'] ?> měs)</td>
        <td class="col-3"> Náklady za měsíc, Kč</td>
        <td class="col-4"> Náklady za období <br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
    </tr>
</table>

<table class="services-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"></td>
        <td class="col-2">A</td>
        <td class="col-3">B = A / <?= $result['calcDifMonth']; ?></td>
        <td class="col-4">C = B x <?= $result['rentDifMonth'] ?></td>
    </tr>
</table>

<?php for ($i=0; $i<count($result['pausalniNaklad']); $i++): ?>

    <table class="services-rows" border="0">
        <tr class="row-1">
            <td class="col-1"><?= $result['pausalniNaklad'][$i] ?></td>
            <td class="col-2"><?= $result['servicesCost'][$i] ?></td>
            <td class="col-3"><?= $result['oneCostPerPeriod'][$i] ?></td>
            <td class="col-4"><?= $result['oneCostRent'][$i] ?></td>
        </tr>
    </table>

<?php endfor;?>


<table class="services-row-total" border="0">
    <tr class="row-1">
        <td class="col-1">Paušální náklady celkem</td>
        <td class="col-2"><?= $result['servicesCostTotal']['commonCosts'] ?></td>
        <td class="col-3"><?= $result['servicesCostTotal']['costsPerPeriod'] ?></td>
        <td class="col-4"><?= $result['servicesCostRentTotal'] ?></td>
    </tr>
</table>

<h2 class="subtitle">III. Náklady na teplou užitkovou vodu (TUV)</h2>

<h3 class="sub-subtitle">Základní složka</h3>


<table class="hot_water-const-costs-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Náklady dle vyúčtování správce, Kč (<?= $result['calcDifMonth'] ?> měs)</td>
        <td class="col-3"> Náklady za měsíc, Kč</td>
        <td class="col-4">Náklady za období <br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
    </tr>
</table>

<table class="hot_water-const-costs-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"> </td>
        <td class="col-2">A</td>
        <td class="col-3"> B = A / <?= $result['calcDifMonth']?> </td>
        <td class="col-4">C = B x <?= $result['rentDifMonth']?></td>
    </tr>
</table>


<table class="hot_water-const-costs-row-3" border="0">
    <tr class="row-1">
        <td class="col-1">Základní složka TUV</td>
        <td class="col-2"><?= !empty($result['hotWaterConstTotal']['commonCosts']) ? $result['hotWaterConstTotal']['commonCosts'] : '-' ?></td>
        <td class="col-3"><?= !empty($result['hotWaterConstTotal']['costsPerPeriod']) ? $result['hotWaterConstTotal']['costsPerPeriod'] : '-' ?></td>
        <td class="col-4"><?= !empty($result['hotWaterConstRentTotal']) ? $result['hotWaterConstRentTotal'] : '-' ?></td>
    </tr>
</table>

<h3 class="sub-subtitle">Spotřební složka</h3>

<table class="hot_water-var-costs-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Naměr. pro výpočet, m3</td>
        <td class="col-3">Cena za jedn., Kč</td>
        <td class="col-4">Náklady za období <br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
    </tr>
</table>

<table class="hot_water-var-costs-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"> </td>
        <td class="col-2">A</td>
        <td class="col-3">B</td>
        <td class="col-4">C = A x B</td>
    </tr>
</table>

<table class="hot_water-var-costs-row-3" border="0">
    <tr class="row-1">
        <td class="col-1">Spotřební složka TUV</td>
        <td class="col-2"><?= !empty($result['hotWaterSum']) && !empty($result['hotWaterPrice']) ? $result['hotWaterSum'] : '-'; ?></td>
        <td class="col-3"><?= !empty($result['hotWaterSum']) && !empty($result['hotWaterPrice']) ? $result['hotWaterPrice'] : '-';?></td>
        <td class="col-4"><?= !empty($result['hotWaterVarTotal']) ? $result['hotWaterVarTotal'] : '-';?></td>
    </tr>
</table>

<h3 class="sub-subtitle">Celkové náklady za TUV</h3>

<table class="hot_water-total-costs-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Náklady za období <br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
        <td class="col-3">Náklady za 1 měsíc</td>
    </tr>
</table>

<table class="hot_water-total-costs-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"></td>
        <td class="col-2">A</td>
        <td class="col-3">B = A / <?= $result['rentDifMonth'] ?></td>
    </tr>
</table>

<table class="hot_water-total-costs-row-3" border="0">
    <tr class="row-1">
        <td class="col-1">Základní složka TUV</td>
        <td class="col-2"><?= !empty($result['hotWaterConstRentTotal']) ? $result['hotWaterConstRentTotal'] : '-' ?></td>
        <td class="col-3"><?= !empty($result['hotWaterConstTotal']['costsPerPeriod']) ? $result['hotWaterConstTotal']['costsPerPeriod'] : '-'?></td>
    </tr>
</table>

<table class="hot_water-total-costs-row-4" border="0">
    <tr class="row-1">
        <td class="col-1">Spotřební složka TUV</td>
        <td class="col-2"><?= !empty($result['hotWaterVarTotal']) ? $result['hotWaterVarTotal'] : '-' ?></td>
        <td class="col-3"><?= !empty($result['hotWaterVarTotalPerMonth']) ? $result['hotWaterVarTotalPerMonth'] : '-' ?></td>
    </tr>
</table>

<table class="hot_water-total-costs-row-5" border="0">
    <tr class="row-1">
        <td class="col-1">Celkem za TUV</td>
        <td class="col-2"><?= !empty($result['hotWaterTotal']['commonCosts']) ? $result['hotWaterTotal']['commonCosts'] : '-' ?></td>
        <td class="col-3"><?= !empty($result['hotWaterTotal']['costsPerPeriod']) ? $result['hotWaterTotal']['costsPerPeriod'] : '-' ?></td>
    </tr>
</table>


<h2 class="subtitle">IV. Náklady na studenou užitkovou vodu (SUV)</h2>


<table class="cold_water-total-costs-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Naměr. pro výpočet, m3</td>
        <td class="col-3">Cena za jedn., Kč</td>
        <td class="col-4">Náklady za období <br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
        <td class="col-5">Náklady za <br>1 měsíc, Kč</td>
    </tr>
</table>

<table class="cold_water-total-costs-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"> </td>
        <td class="col-2">A</td>
        <td class="col-3">B</td>
        <td class="col-4">C = A x B</td>
        <td class="col-5">D = C / <?= $result['rentDifMonth'] ?></td>
    </tr>
</table>

<table class="cold_water-total-costs-row-3" border="0">
<tr class="row-1">
    <td class="col-1">Náklady na SUV</td>
    <td class="col-2"><?= !empty($result['coldWaterSum']) ? $result['coldWaterSum'] : '-';?></td>
    <td class="col-3"><?= !empty($result['coldWaterSum']) ? $result['coldWaterPrice'] : '-';?></td>
    <td class="col-4"><?= !empty($result['coldWaterSum']) ? $result['coldWaterVarTotal'] : '-';?></td>
    <td class="col-5"><?= !empty($result['coldWaterSum']) ? $result['coldWaterTotalPerMonth'] : '-';?></td>
</tr>
</table>

<table class="cold_water-total-costs-row-4" border="0">
<tr class="row-1">
    <td class="col-1">Náklady na SUV použitou<br> pro přípravu TUV</td>
    <td class="col-2"><?= !empty($result['hotWaterSum']) ? $result['hotWaterSum'] : '-';?></td>
    <td class="col-3"><?= !empty($result['hotWaterSum']) ? $result['coldForHotWaterPrice'] : '-';?></td>
    <td class="col-4"><?= !empty($result['hotWaterSum']) ? $result['coldForHotWaterVarTotal'] : '-';?></td>
    <td class="col-5"><?= !empty($result['hotWaterSum']) ? $result['coldForHotWaterTotalPerMonth'] : '-';?></td>
</tr>
</table>

<table class="cold_water-total-costs-row-5" border="0">
<tr class="row-1">
    <td class="col-1">Celkem za SUV</td>
    <td class="col-2">-</td>
    <td class="col-3">-</td>
    <td class="col-4"><?= !empty($result['coldWaterTotal']['commonCosts']) ? $result['coldWaterTotal']['commonCosts'] : '-';?></td>
    <td class="col-5"><?= !empty($result['coldWaterTotal']['costsPerPeriod']) ? $result['coldWaterTotal']['costsPerPeriod'] : '-';?></td>
</tr>
</table>

<h2 class="subtitle">V. Náklady na ústřední topení (ÚT)</h2>

<h3 class="sub-subtitle">Základní složka</h3>

<table class="heating-const-costs-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Náklady dle vyúčtování správce, Kč (období - <?= $result['calcDifMonth'] ?> měs)</td>
        <td class="col-3"> Náklady za měsíc, Kč</td>
        <td class="col-4">Náklady za období <br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
    </tr>
</table>

<table class="heating-const-costs-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"> </td>
        <td class="col-2">A</td>
        <td class="col-3"> B = A / <?= $result['calcDifMonth']?> </td>
        <td class="col-4">C = B x <?= $result['rentDifMonth']?></td>
    </tr>
</table>


<table class="heating-const-costs-row-3" border="0">
    <tr class="row-1">
        <td class="col-1">Základní složka ÚT</td>
        <td class="col-2"><?= $result['heatingConstTotal']['commonCosts'] ?></td>
        <td class="col-3"><?= $result['heatingConstTotal']['costsPerPeriod'] ?></td>
        <td class="col-4"><?= $result['heatingConstRentTotal'] ?></td>
    </tr>
</table>

<h3 class="sub-subtitle">Spotřební složka</h3>

<table class="heating-var-costs-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Naměr. pro vypočet, jedn.</td>
        <td class="col-3">Cena za jedn., Kč</td>
        <td class="col-4">Náklady za období <br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
    </tr>
</table>

<table class="heating-var-costs-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"> </td>
        <td class="col-2">A</td>
        <td class="col-3">B</td>
        <td class="col-4">C = A x B</td>
    </tr>
</table>

<table class="heating-var-costs-row-3" border="0">
<tr class="row-1">
    <td class="col-1">Spotřební složka ÚT</td>
    <td class="col-2"><?= !empty($result['heatingSum']) ? $result['heatingSum'] : '-';?></td>
    <td class="col-3"><?= !empty($result['heatingSum']) ? $result['heatingPrice'] : '-';?><?= !empty($result['changedHeatingCosts']) ? '*' : '';?></td>
    <td class="col-4"><?= !empty($result['heatingSum']) ? $result['heatingVarTotal'] : '-';?></td>
</tr>
</table>
<?php if (!empty($result['changedHeatingCosts'])): ?>
<p class="note"> * Cena za jednotku = Náklady na zkorigovanou spotřební složku / Spotřeba tepla za období vyúčtování správce </p>
<?php endif; ?>


<h3 class="sub-subtitle">Celkové náklady za ÚT</h3>

<table class="heating-total-costs-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Náklady za období <br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
        <td class="col-3">Náklady za 1 měsíc</td>
    </tr>
</table>

<table class="heating-total-costs-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"></td>
        <td class="col-2">A</td>
        <td class="col-3">B = A / <?= $result['rentDifMonth'] ?></td>
    </tr>
</table>

<table class="heating-total-costs-row-3" border="0">
    <tr class="row-1">
        <td class="col-1">Základní složka ÚT</td>
        <td class="col-2"><?= $result['heatingConstRentTotal'] ?></td>
        <td class="col-3"><?= $result['heatingConstTotal']['costsPerPeriod']?></td>
    </tr>
</table>

<table class="heating-total-costs-row-4" border="0">
    <tr class="row-1">
        <td class="col-1">Spotřební složka ÚT</td>
        <td class="col-2"><?= $result['heatingVarTotal'] ?></td>
        <td class="col-3"><?= $result['heatingVarTotalPerMonth'] ?></td>
    </tr>
</table>

<table class="heating-total-costs-row-5" border="0">
    <tr class="row-1">
        <td class="col-1">Celkem za ÚT</td>
        <td class="col-2"><?= $result['heatingTotal']['commonCosts'] ?></td>
        <td class="col-3"><?= $result['heatingTotal']['costsPerPeriod'] ?></td>
    </tr>
</table>

<h2 class="subtitle">VI. Vyúčtování</h2>

<table class="calc-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Náklady za období<br>vyúčtování, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
        <td class="col-3"> Korekce, %</td>
        <td class="col-4">Náklady za období<br> po korekci, Kč (<?= $result['rentDifMonth'] ?> měs)</td>
        <td class="col-5"> Náklady za<br> 1 měsíc, Kč</td>
    </tr>
</table>

<table class="calc-row-2" border="0">
    <tr class="row-1">
        <td class="col-1"></td>
        <td class="col-2">A</td>
        <td class="col-3">B</td>
        <td class="col-4">C = A + (A * B / 100)</td>
        <td class="col-5">D = C / <?= $result['rentDifMonth'] ?></td>
    </tr>
</table>

<table class="calc-row-3" border="0">
    <tr class="row-1">
        <td class="col-1">Paušální náklady</td>
        <td class="col-2"><?= $result['servicesCostRentTotal'] ?></td>
        <td class="col-3"><?= !empty($result['servicesCostCorrection']) ? $result['servicesCostCorrection'] : '-'; ?></td>
        <td class="col-4"><?= $result['servicesCostRentCorrectionTotal']['commonCosts'] ?></td>
        <td class="col-5"><?= $result['servicesCostRentCorrectionTotal']['costsPerPeriod']?></td>
    </tr>
</table>

<table class="calc-row-4" border="0">
    <tr class="row-1">
        <td class="col-1">Náklady na TUV</td>
        <td class="col-2"><?= $result['hotWaterTotal']['commonCosts']; ?></td>
        <td class="col-3"><?= !empty($result['hotWaterCorrection']) ? $result['hotWaterCorrection'] : '-'; ?></td>
        <td class="col-4"><?=$result['hotWaterCorrectionTotal']['commonCosts']?></td>
        <td class="col-5"><?=$result['hotWaterCorrectionTotal']['costsPerPeriod']?></td>
    </tr>
</table>

<table class="calc-row-5" border="0">
    <tr class="row-1">
        <td class="col-1">Náklady na SUV</td>
        <td class="col-2"><?= $result['coldWaterTotal']['commonCosts']; ?></td>
        <td class="col-3"><?= !empty($result['coldWaterCorrection']) ? $result['coldWaterCorrection'] : '-'; ?></td>
        <td class="col-4"><?= $result['coldWaterCorrectionTotal']['commonCosts']; ?></td>
        <td class="col-5"><?= $result['coldWaterCorrectionTotal']['costsPerPeriod']; ?></td>
    </tr>
</table>

<table class="calc-row-6" border="0">
    <tr class="row-1">
        <td class="col-1">Náklady na ÚT</td>
        <td class="col-2"><?= $result['heatingTotal']['commonCosts'] ?></td>
        <td class="col-3"><?= !empty($result['heatingCorrection']) ? $result['heatingCorrection'] : '-'; ?></td>
        <td class="col-4"><?= $result['heatingCorrectionTotal']['commonCosts']; ?></td>
        <td class="col-5"><?= $result['heatingCorrectionTotal']['costsPerPeriod']; ?></td>
    </tr>
</table>

<table class="calc-row-7" border="0">
    <tr class="row-1">
        <td class="col-1">Celkové náklady</td>
        <td class="col-2"></td>
        <td class="col-3"></td>
        <td class="col-4"><?= $result['allCostsCorrectionTotal']['commonCosts']; ?></td>
        <td class="col-5"><?= $result['allCostsCorrectionTotal']['costsPerPeriod']; ?></td>
    </tr>
</table>




<table class="calc-row-8" border="0">
    <tr class="row-1">
        <td class="col-1">Součet uhrazených záloh, Kč</td>
        <td class="col-2"></td>
        <td class="col-3"></td>
        <td class="col-4"><?= $result['advancedPayments'] ?></td>
        <td class="col-5"></td>
    </tr>
</table>

<table class="calc-row-9" border="0">
    <tr class="row-1">
        <td class="col-1"><i><?= $result['advancedPaymentsDesc'] ?></i></td>
        <td class="col-2"></td>
        <td class="col-3"></td>


    </tr>
</table>

<table class="calc-row-10" border="0">
    <tr class="row-1">
        <td class="col-1">Výsledek vyúčtování </td>
        <td class="col-2"></td>
        <td class="col-3"></td>
        <td class="col-4"><?= $result['calculationResult']['value'] ?></td>
        <td class="col-5"><?= $result['calculationResult']['text'] ?></td>
    </tr>
</table>

<div class="calc-payment">
    <?= $result['calculationResult']['text'] == 'Nedoplatek' && !empty($result['accountNumber']) ? 'Prosím o úhradu nedoplatku na účet ' . '<b>' . $result['accountNumber'] . '</b>' : '' ?>
</div>


<div class="date">
    <span>Datum: </span>
    <span><?=$result['calculationDate']; ?></span>
</div>

<div class="webmark"><i>www.pronajemonline.cz</i></div>













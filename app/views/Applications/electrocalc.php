
    <?php  //debug($result); ?>
    <div class="main-title">
        <h1 class="title">Vyúčtování spotřeby elektřiny za období<br>
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
        <h3 class="sub-subtitle">Dodavatel elektřiny:</h3>
        <span>
            <?= !empty($result['supplierName']) ? $result['supplierName'] : 'Neuvedeno' ?>
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

    <h2 class="subtitle">I. Odečty elektroměru</h2>

    <table class="electrometers-row-1" border="0">
        <tr class="row-1">
            <td class="col-1">Media</td>
            <td class="col-2">Výrobní číslo</td>
            <td class="col-3">Počat. stav</td>
            <td class="col-4">Koneč. stav</td>
            <td class="col-5">Rozdíl náměr.</td>
        </tr>
    </table>
    <table class="electrometers-row-2" border="0">
        <tr class="row-2">
            <td class="col-1">Elektřina kWh</td>
            <td class="col-2"><?= $result['meterNumberOne'];?></td>
            <td class="col-3"><?= $result['initialValueOne'];?></td>
            <td class="col-4"><?= $result['endValueOne'];?></td>
            <td class="col-5"><?= $result['diffElectroKWh'];?></td>
        </tr>
    </table>
    <table class="electrometers-row-3" border="0">
        <tr class="row-1">
            <td class="col-1">Zdroj počátečního stavu elektroměru: </td>
            <td class="col-2" colspan="4"><?= !empty($result['originMeterStart']) ? $result['originMeterStart'] : 'Neuvedeno' ?></td>
        </tr>
        <tr class="row-2">
            <td class="col-1">Zdroj konečného stavu elektroměru: </td>
            <td class="col-2" colspan="4"><?= !empty($result['originMeterEnd']) ? $result['originMeterEnd'] : 'Neuvedeno' ?></td>
        </tr>
    </table>

    <h2 class="subtitle">II. Náklady na elektřinu </h2>

    <table class="electro-costs-row1" border="0">
        <tr class="row-1">
            <td class="col-1">Položka</td>
            <td class="col-2">Účtované množství</td>
            <td class="col-3">Průměrná jednotková cena, Kč</td>
            <td class="col-4">Celkem, Kč</td>
        </tr>
    </table>
    <table class="electro-costs-row2-3" border="0">
        <tr class="row-2">
            <td class="col-1">Elektřina dle měsíční sazby</td>
            <td class="col-2"><?= $result['rentDifMonth']; ?> měs</td>
            <td class="col-3"><?= !empty($result['electroPriceMonth']) ? $result['electroPriceMonth'] : '-'; ?></td>
            <td class="col-4"><?= !empty($result['totalElectroMonths']) ? $result['totalElectroMonths'] : '-'; ?></td>
        </tr>
        <tr class="row-3">
            <td class="col-1">Elektřina dle kWh</td>
            <td class="col-2"><?= $result['diffElectroKWh']; ?> KWh</td>
            <td class="col-3"><?= !empty($result['electroPriceKWh']) ? $result['electroPriceKWh'] : '-'; ?></td>
            <td class="col-4"><?= !empty($result['totalElectroKWh']) ? $result['totalElectroKWh'] : '-'; ?></td>
        </tr>
    </table>
    <?php if (!empty($result['electroPriceAdd'])):?>
        <table class="electro-costs-row4" border="0">
            <tr class="row-1">
                <td class="col-1"><?= $result['electroPriceAddDesc'];?></td>
                <td class="col-2"><?= $result['electroPriceAdd']; ?> </td>
            </tr>
        </table>


    <?php endif;?>



    <table class="electro-costs-row5" border="0">
        <tr class="row-4">
            <td class="col-1"><h4>Celkem za elektřinu, Kč</h4></td>
            <td class="col-2" colspan="3"><h4><?= $result['allCostsTotal']['commonCosts']; ?></h4></td>
    </table>

    <h2 class="subtitle">III. Vyúčtování </h2>

    <table class="calculation-row1">
        <tr class="row-1">
            <td class="col-1">Položka</td>
            <td class="col-2">Částka za období, Kč</td>
            <td class="col-3">Částka za měsíc, Kč</td>
    </table>
    <table class="calculation-row2-3">
        <tr class="row-2">
            <td class="col-1"><h4>Elektřina celkem</h4></td>
            <td class="col-2"><h4><?= $result['allCostsTotal']['commonCosts']; ?></h4></td>
            <td class="col-3"><h4><?= $result['allCostsTotal']['costsPerPeriod']; ?></h4></td>
        <tr class="row-3">
            <td class="col-1">Součet uhrazených záloh</td>
            <td class="col-2"><?= $result['advancedPaymentsArray']['commonCosts']; ?></td>
            <td class="col-3">-</td>
    </table>
    <table class="calculation-row4" border="0">
        <tr class="row-1">
            <td class="col-1"><i><?= $result['advancedPaymentsDesc'] ?></i></td>
            <td class="col-2"></td>
            <td class="col-3"></td>
        </tr>
    </table>
    <table class="calculation-row5">
        <tr class="row-4">
            <td class="col-1"><h4>Výsledek vyúčtování</h4></td>
            <td class="col-2"><h4><?= $result['calculationResult']['value']; ?></h4></td>
            <td class="col-3"><h4><?= $result['calculationResult']['text']; ?></h4></td>
    </table>

    <div class="calc-payment">
        <?= $result['calculationResult']['text'] == 'Nedoplatek' && !empty($result['accountNumber']) ? 'Prosím o úhradu nedoplatku na účet ' . '<b>' . $result['accountNumber'] . '</b>' : '' ?>
    </div>

    <div class="date">
        <span>Datum: </span>
        <span><?=$result['calculationDate']; ?></span>
    </div>

   <div class="webmark"><i>www.pronajemonline.cz</i></div>



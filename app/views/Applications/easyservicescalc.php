<?php //debug($result); ?>
<div class="main-title">
    <h1 class="title">Vyúčtování služeb spojených s užíváním bytu za rok<br>
        <?= $result['rentYearDate']?>
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

<div class="admin-text-left">
    <h3 class="sub-subtitle">Spravce domu:</h3>
    <span>
            <?= !empty($result['adminName']) ? $result['adminName'] : 'Neuvedeno' ?>
        </span>
</div>

<div class="date-text-right">
    <h3 class="sub-subtitle">Období vyúčtování </h3>
    <span>
            <?= $result['rentYearDate'] ?>
        </span>
</div>



<h2 class="subtitle">I. Náklady na jednotku </h2>

<table class="services-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Pololožka </td>
        <td class="col-2">Částka za rok, Kč</td>
        <td class="col-3"> Částka za měsíc, Kč</td>
    </tr>
</table>


<?php for ($i=0; $i<count($result['pausalniNaklad']); $i++): ?>

    <table class="services-rows" border="0">
        <tr class="row-1">
            <td class="col-1"><?= $result['pausalniNaklad'][$i] ?></td>
            <td class="col-2"><?= $result['servicesCost'][$i] ?></td>
            <td class="col-3"><?= $result['oneCostPerPeriod'][$i] ?></td>
        </tr>
    </table>

<?php endfor;?>


<table class="services-row-total" border="0">
    <tr class="row-1">
        <td class="col-1">Náklady celkem</td>
        <td class="col-2"><?= $result['servicesCostTotal']['commonCosts'] ?></td>
        <td class="col-3"><?= $result['servicesCostTotal']['costsPerPeriod'] ?></td>
    </tr>
</table>




<h2 class="subtitle">II. Vyúčtování</h2>

<table class="calc-row-1" border="0">
    <tr class="row-1">
        <td class="col-1">Položka </td>
        <td class="col-2">Částka za rok, Kč</td>
        <td class="col-3"> Částka za měsíc, Kč</td>
    </tr>
</table>



<table class="calc-row-2" border="0">
    <tr class="row-1">
        <td class="col-1">Náklady celkem, Kč</td>
        <td class="col-2"><?= $result['servicesCostTotal']['commonCosts'] ?></td>
        <td class="col-3"><?= $result['servicesCostTotal']['costsPerPeriod'] ?></td>
    </tr>
</table>

<table class="calc-row-3" border="0">
    <tr class="row-1">
        <td class="col-1">Součet uhrazených záloh, Kč</td>
        <td class="col-2"><?= $result['advancedPayments'] ?></td>
        <td class="col-3"></td>
    </tr>
</table>


<table class="calc-row-4" border="0">
    <tr class="row-1">
        <td class="col-1"><i><?= $result['advancedPaymentsDesc'] ?></i></td>
        <td class="col-2"></td>
        <td class="col-3"></td>
    </tr>
</table>

<table class="calc-row-5" border="0">
    <tr class="row-1">
        <td class="col-1">Výsledek vyúčtování </td>
        <td class="col-2"><?= $result['calculationResult']['value'] ?></td>
        <td class="col-3"><?= $result['calculationResult']['text'] ?></td>
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













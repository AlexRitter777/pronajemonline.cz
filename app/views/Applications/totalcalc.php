

<div class="main-title">
    <h1 class="title">Souhrnné vyúčtování</h1>
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


<h2 class="subtitle">Souhrnné vyúčtování</h2>

<table class="deposit-calc-1" border="0">
    <tr class="row-1">
        <td class="col-1">Pololožka</td>
        <td class="col-2">Částka, Kč</td>
    </tr>
</table>


<?php for ($i=0; $i<count($result['depositItems']); $i++): ?>

    <table class="deposit-calc-rows" border="0">
        <tr class="row-1">
            <?php if (empty($result['damageDesc'][$i])): ?>
                <td class="col-1"><?= $result['depositItems'][$i] . ' za období ' . date("d.m.Y", strtotime($result['itemsStartDate'][$i])) . ' - ' . date("d.m.Y", strtotime($result['itemsFinishDate'][$i]))?></td>
            <?php else:?>
                <td class="col-1"><?= $result['depositItems'][$i] ?><br>
                    <span class="damage_desc"><?= $result['damageDesc'][$i]?></span>
                </td>
            <?php endif;?>
            <td class="col-2" style="vertical-align: top;"><?= $result['depositItemsPrice'][$i] ?></td>
        </tr>
    </table>

<?php endfor;?>

<table class="deposit-calc-last-row" border="0">
    <tr class="row-1">
        <td class="col-1"><?= $result['depositResult']['text']; ?></td>
        <td class="col-2"><?= $result['depositResult']['value']; ?></td>
    </tr>
</table>

<div class="calc-payment">
    <?= $result['depositResult']['text'] == 'Nedoplatek' && !empty($result['accountNumber']) ? 'Prosím o úhradu nedoplatku na účet ' . '<b>' . $result['accountNumber'] . '</b>' : '' ?>
</div>

<div class="date">
    <span>Datum: </span>
    <span><?=$result['calculationDate']; ?></span>
</div>

<div class="webmark"><i>www.pronajemonline.cz</i></div>



















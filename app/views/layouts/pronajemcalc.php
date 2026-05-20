<!doctype html>
<html lang="cz">
<head>
    <?=$this->getMeta(); ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="/">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/<?= $result['calcType']?>calc.css">
    <link rel="stylesheet" type="text/css" href="css/includes.css">
    <link rel="stylesheet" type="text/css" href="css/calc.css">
    <link rel="stylesheet" type="text/css"  href="css/user.css">
    <link rel="stylesheet" type="text/css"  href="css/style.css">
    <link rel="stylesheet" media="print"  href="css/print.css"/>
    <link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.3.3/dist/jBox.all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.3.3/dist/jBox.all.min.js"></script>

</head>


<body>

<?= $header?>

<div class="button-bar <?= $result['calculationName'] ? 'button-bar-calc-name' : ''; ?>">
    <?php if($result['calculationName']): ?>
        <div class="calculation-name"><?= $result['calculationName']; ?></div>
    <?php endif;?>
    <div class="button-bar-inner">
        <?php if(is_user_logged_in()): ?>
            <a class="button-bar-link calc-list-btn" href="/user/calculations?calc_type=<?= $result['calcType'] ;?>calc">Seznam vyúčtování</a>
        <?php endif; ?>
        <a class="button-bar-link" href="/user/calculations/create-pdf?calculation_type=<?= $result['calcType'] ;?>&id=<?= $result['id'] ;?>">PDF</a>
        <a class="button-bar-link" href="/calculations/<?= $result['calcType']; ?>form/edit?id=<?= $result['id'] ;?>">Upravit</a>
        <a class="button-bar-link" href="#" id="print-button">Tisk</a>
        <?php if(is_user_logged_in()): ?>
            <?php if(!empty($result['calculationId'])): ?>
            <a class="button-bar-link" href="user/calculations/save?calculation_type=<?= $result['calcType'] ;?>&id=<?= $result['id'] ;?>&calculation_id=<?= $result['calculationId'];?>" >Uložit</a>
            <?php endif;?>
            <a class="button-bar-link btn_open_modal_save_as" href="#" data-item="calculation" data-id="<?= $result['id'] ;?>" data-title="Uložit kalkulaci jako..." data-type="<?= $result['calcType'];?>">Uložit jako</a>
        <?php else:?>
            <a class="button-bar-link un-logged-save" data-item="login" data-title="Přihlášení" href="" >Uložit jako</a>
        <?php endif;?>
        <a class="button-bar-link" href="/user/calculations/new" id="home-button">Nový</a>
    </div>
</div>

<div class="content container">

    <?= $content; ?>
</div>



<?= $footer ?>
<!--<script type="module" src="--><?php //= vite_asset('src/js/app.js')?><!--"></script>-->

<!--<script src="js/calculations.js" type="module"></script>-->

</body>
</html>

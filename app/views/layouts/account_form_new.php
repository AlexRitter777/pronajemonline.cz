<!DOCTYPE html>
<html lang="cs">

<head>
    <?=$this->getMeta(); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="css/includes.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.3.3/dist/jBox.all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.3.3/dist/jBox.all.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LflMpQgAAAAAMN2q092nkMkkOCUicv4D60lxZc9"></script>
    <script src="js/form_validation.js" type="module"></script>



</head>

<?php require_once APP . "/views/Includes/google_tag.php"; ?>


<body>

    <div id="opacity" class="opacity-for-loader">
        <?= $header;?>

            <section class="content user-content">
                <div class="left-side-bar main"><?= $left_side_bar; ?></div>
                <div class="center-content main "><?= $content; ?></div>
            </section>

        <?= $footer; ?>
    </div>
    <div style="display: none" class="loader-wrapper loader-wrapper_profile">
        <div class="loader"></div>
    </div>

    <script src="js/calculations.js" type="module"></script>
    <script src="js/hamburger.js"></script>


</body>
</html>
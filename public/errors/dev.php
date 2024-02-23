<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chyba</title>
</head>
<body>

<h1>Vyskytla se chyba!</h1>
<p><b>Kód chyby:</b> <?= $errno?></p>
<p><b>Popis chyby:</b> <?= $errstr?></p>
<p><b>Soubor:</b> <?= $errfile?></p>
<p><b>Řádek :</b> <?= $errline?></p>

</body>
</html>

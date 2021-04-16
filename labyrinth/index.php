<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
    <?php
    $fp = fopen('save.txt', 'r');
    if (!$fp) {
        echo "Impossible d'ouvrir le fichier save.txt";
    }

    $tableau = [];
    while (false !== ($line = fgets($fp))) {
        $tableau[] = str_split($line);
    }

    // var_dump($tableau);


    ?>
    <pre style="font-family: 'Courier New', Courier, monospace">

<?php
foreach ($tableau as $case) {
    foreach ($case as $subcase) {
        if ($subcase == "m") {
            echo "█";
            // echo "▓";
        }
        if ($subcase == "v") {
            echo "&nbsp";
        }
        if ($subcase == "j") {
            echo "֍";
        }
    }
    echo  "<br>";
}
?>
</pre>
    <div class="block">
        <div>
            <div class="inner">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</div>
            <div class="inner"><input type="button" value="haut"></div>
        </div>
        <div id="outer">
        <div class="inner"><input type="button" value="gauche"></div>
        <div class="inner"><input type="button" value="bas"></div>
        <div class="inner"><input type="button" value="droite"></div>
        </div>
    </div>
</body>

</html>
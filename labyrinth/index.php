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
            echo "X";
        }
    }
    echo  "<br>";
}
?>
</pre>
    <div class="block">
        <div>
            <div class="inner">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</div>
            <div class="inner"><button type="submit" class="msgBtn" onClick="return false;">haut</button></div>
        </div>
        <div id="outer">
            <div class="inner"><button type="submit" class="msgBtn" onClick="return false;">gauche</button></div>
            <div class="inner"><button type="submit" class="msgBtn2" onClick="return false;">bas</button></div>
            <div class="inner"><button class="msgBtnBack">droite</button></div>
        </div>
    </div>
</body>

</html>
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
    

    <?php
    if (array_key_exists('haut', $_POST)) {
        haut($tableau);
    } else if (array_key_exists('bas', $_POST)) {
        bas($tableau);
    } else if (array_key_exists('gauche', $_POST)) {
        gauche($tableau);
    } else if (array_key_exists('droite', $_POST)) {
        droite($tableau);
    }

    function findPlayer($tableau)
    {
        $i = 0;
        foreach ($tableau as $line) {
            if ($key = array_search ( "j", $line)){
                return [$i,$key];
            }
            $i++;
        }
    }

    function haut($tableau)
    {
        $key = findPlayer($tableau);
        echo $key[0] . $key[1];
        echo "This is haut that is selected";
    }
    function bas($tableau)
    {
        $key = findPlayer($tableau);
        echo "This is bas that is selected";
        if ($tableau[$key[0]+1][$key[1]] == "v"){
            $tableau[$key[0]][$key[1]] = "v";
            $tableau[$key[0]+1][$key[1]] = "j";
            // header("Refresh:0");
        }
    }
    function gauche($tableau)
    {
        $key = findPlayer($tableau);
        echo "This is gauche that is selected";
    }
    function droite($tableau)
    {
        $key = findPlayer($tableau);
        echo "This is droite that is selected";
    }

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
    <form method="post">
    <div>
        <div class="block"> <input type="submit" name="haut" class="button" value="haut" /></div>
    </div>
    <input type="submit" name="gauche" class="button" value="gauche" />
    <input type="submit" name="bas" class="button" value="bas" />
    <input type="submit" name="droite" class="button" value="droite" />
    </form>
    <div class="block">

    </div>
</body>

</html>
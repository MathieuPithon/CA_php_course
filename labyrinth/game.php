<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Labyrinthe</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body id="page">
    <pre style="font-family: 'Courier New', Courier, monospace">
    <?php
    session_start();

    if ($_SESSION['previous_location'] != 'game') resetGame();
    $_SESSION['previous_location'] = 'game';
    if (!isset($_SESSION['tableau'])) {
        $_SESSION['tableau'] = [];
    }

    fillTableau();


    if (array_key_exists('haut', $_POST)) {
        haut();
    } else if (array_key_exists('bas', $_POST)) {
        bas();
    } else if (array_key_exists('gauche', $_POST)) {
        gauche();
    } else if (array_key_exists('droite', $_POST)) {
        droite();
    } else if (array_key_exists('reset', $_POST)) {
        resetGame();
        echo "labyrinthe remis à zéro";
    } else if (array_key_exists('pseudoValidation', $_POST)) {
        if ($_POST['pseudo'] == "") {
            echo "ERREUR: vous n'avez pas entré de pseudo";
        } else {
            $_SESSION['pseudo'] = $_POST['pseudo'];
            echo "votre nouveau pseudo est: " . $_SESSION['pseudo'];
        }
    } else if (array_key_exists('mainmenu', $_POST)) {
        header("Location: http://caphp/labyrinth/index");
    }


    function findPlayer()
    {
        $i = 0;
        foreach ($_SESSION['tableau'] as $line) {
            if ($row = array_search("j", $line)) {
                return [$i, $row];
            }
            $i++;
        }
    }

    function haut()
    {
        $key = findPlayer();
        // $spaces = array('v', 'o');
        if (in_array($_SESSION['tableau'][$key[0] - 1][$key[1]], array('v', 'o'))) {
            if ($_SESSION['tableau'][$key[0] - 1][$key[1]] == "o") $_SESSION['nb_objets_restant']--;
            $_SESSION['tableau'][$key[0]][$key[1]] = "v";
            $_SESSION['tableau'][$key[0] - 1][$key[1]] = "j";
        }
    }

    function bas()
    {
        $key = findPlayer();
        $spaces = array('v', 'o');
        if (in_array($_SESSION['tableau'][$key[0] + 1][$key[1]], $spaces)) {
            if ($_SESSION['tableau'][$key[0] + 1][$key[1]] == "o") $_SESSION['nb_objets_restant']--;
            $_SESSION['tableau'][$key[0]][$key[1]] = "v";
            $_SESSION['tableau'][$key[0] + 1][$key[1]] = "j";
        }
    }

    function gauche()
    {
        $key = findPlayer();
        if (in_array($_SESSION['tableau'][$key[0]][$key[1] - 1], array('v', 'o'))) {
            if ($_SESSION['tableau'][$key[0]][$key[1] - 1] == "o") $_SESSION['nb_objets_restant']--;
            $_SESSION['tableau'][$key[0]][$key[1]] = "v";
            $_SESSION['tableau'][$key[0]][$key[1] - 1] = "j";
        }
    }

    function droite()
    {
        $key = findPlayer();
        if ($_SESSION['tableau'][$key[0]][$key[1] + 1] == "w") {
            if ($_SESSION['nb_objets_restant'] > 0) {
                echo "vous n'avez pas ramassé tout les objets, veuillez tous les récupérer avant de sortir";
            } else {
                $_SESSION['tableau'][$key[0]][$key[1]] = "v";
                $_SESSION['tableau'][$key[0]][$key[1] + 1] = "j";
                victory();
            }
        }
        if (in_array($_SESSION['tableau'][$key[0]][$key[1] + 1], array('v', 'o'))) {
            if ($_SESSION['tableau'][$key[0]][$key[1] + 1] == "o") $_SESSION['nb_objets_restant']--;
            $_SESSION['tableau'][$key[0]][$key[1]] = "v";
            $_SESSION['tableau'][$key[0]][$key[1] + 1] = "j";
        }
    }

    function resetGame()
    {
        $_SESSION['tableau'] = [];
        $_SESSION['nb_objets_restant'] = $_SESSION['nb_objets'];
        fillTableau();
    }

    function printTableau()
    {
        echo '<br>';
        foreach ($_SESSION['tableau'] as $case) {
            foreach ($case as $subcase) {
                if ($subcase == "m") {
                    echo "█";
                }
                if ($subcase == "v") {
                    echo "&nbsp";
                }
                if ($subcase == "j") {
                    echo "֍";
                }
                if ($subcase == "w") {
                    echo "∏";
                }
                if ($subcase == "o") {
                    echo "o";
                }
            }
            echo  "<br>";
        }
    }

    function fillTableau()
    {
        $fp = fopen('levels/' . $_SESSION['level'] . ".txt", 'r');
        if (!$fp) {
            echo "Impossible d'ouvrir le fichier save.txt";
        }
        if ($_SESSION['tableau'] == []) {
            while (false !== ($line = fgets($fp))) {
                $_SESSION['tableau'][] = str_split($line);
            }
        }
    }

    function victory()
    {
        resetGame();
        header("Location: http://caphp/labyrinth/victory");
    }



    printTableau();

    ?>
    </pre>
    <form method="post">
        <table>
            <tr>
                <th></th>
                <th><input type="submit" name="haut" class="button" value="haut" id="haut" /></th>
                <th></th>
            </tr>
            <tr>
                <th><input type="submit" name="gauche" class="button" value="gauche" id="gauche" /></th>
                <th><input type="submit" name="bas" class="button" value="bas" id="bas" /></th>
                <th><input type="submit" name="droite" class="button" value="droite" id="droite" /></th>
            </tr>
        </table>
        <br> nombre d'objets restant à ramasser: <?php echo $_SESSION['nb_objets_restant'] ?>
        <div class="block">
            <br> <br>
            <input type="submit" name="reset" class="button" value="retourner au début" />
        </div>
        <input type="text" name="pseudo" /></div>
        <input type="submit" name="pseudoValidation" class="button" value="changer de pseudo" />
        votre pseudo actuel est <?php echo $_SESSION['pseudo']; ?>
        <br><br>
        <input type="submit" name="mainmenu" class="button" value="retour au menu principal" />
    </form>
    <script>
        var page = document.getElementById("page");

        page.addEventListener("keydown", function(event) {
            if (event.keyCode == 38) {
                document.getElementById("haut").click();
            } else if (event.keyCode == 37) {
                document.getElementById("gauche").click();
            } else if (event.keyCode == 39) {
                document.getElementById("droite").click();
            } else if (event.keyCode == 40) {
                document.getElementById("bas").click();
            }
        });
    </script>
</body>

</html>
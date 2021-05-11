<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Labyrinthe</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
    <pre style="font-family: 'Courier New', Courier, monospace">
    <?php
    session_start();
    $mysqli = new mysqli("localhost:3306", "root", "", "phpLabyrinthe");

    if ($mysqli->connect_errno) {
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }


    $debug = $_SESSION["id"] - 1;
    if ($result = $mysqli->query("SELECT id_labyrinthe, height, line FROM maze_line WHERE id_labyrinthe = " . $debug . " ORDER BY height ASC")) {
        $tableau = [];
        while ($row = $result->fetch_assoc()) {
            $tableau[] = str_split($row["line"]);
        }
    }
 
    if ($result = $mysqli->query("SELECT id, name FROM nickname WHERE id = " . $_SESSION['id'])) {
        $row = $result->fetch_assoc();
        $pseudo = $row["name"];
        
    }
    



    if ($_SESSION['previous_location'] != 'game') resetGame($tableau);
    $_SESSION['previous_location'] = 'game';

    echo $_SESSION['test'];
    echo $_SESSION['id'];
    echo sizeof($tableau);
    // tryFillTableau($tableau);
    checkInputs($tableau);
    printTableau($tableau);

    




    function checkInputs($tableau)
    {
        global $mysqli;
        if (array_key_exists('haut', $_POST)) {
            haut($tableau);
        } else if (array_key_exists('bas', $_POST)) {
            bas($tableau);
        } else if (array_key_exists('gauche', $_POST)) {
            gauche($tableau);
        } else if (array_key_exists('droite', $_POST)) {
            droite($tableau);
        } else if (array_key_exists('reset', $_POST)) {
            resetGame($tableau);
            echo "labyrinthe remis à zéro";
        } else if (array_key_exists('pseudoValidation', $_POST)) {
            if ($_POST['pseudo'] == "") {
                echo "ERREUR: vous n'avez pas entré de pseudo";
            } else {
                $query = "DELETE FROM nickname WHERE id=" . $_SESSION['id'];
                $mysqli->query($query);

                $query = "INSERT INTO nickname (id, name) VALUES (?, ?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ss", $_SESSION['id'], $_POST['pseudo']);
                $stmt->execute();
                header("Refresh:0");
            }
        } else if (array_key_exists('mainmenu', $_POST)) {
            header("Location: http://caphp/labyrinth/index");
        }
    }

    function findPlayer($tableau)
    {
        $i = 0;
        foreach ($tableau as $line) {
            if ($key = array_search("j", $line)) {
                return [$i, $key];
            }
            $i++;
        }
    }

    function haut($tableau)
    {
        $key = findPlayer($tableau);
        if ($tableau[$key[0] - 1][$key[1]] == "v") {
            $tableau[$key[0]][$key[1]] = "v";
            $tableau[$key[0] - 1][$key[1]] = "j";
        }
        updateBDD($tableau);
    }

    function bas($tableau)
    {
        $key = findPlayer($tableau);
        if ($tableau[$key[0] + 1][$key[1]] == "v") {
            $tableau[$key[0]][$key[1]] = "v";
            $tableau[$key[0] + 1][$key[1]] = "j";
        }
        updateBDD($tableau);
    }

    function gauche($tableau)
    {
        $key = findPlayer($tableau);
        if ($tableau[$key[0]][$key[1] - 1] == "v") {
            $tableau[$key[0]][$key[1]] = "v";
            $tableau[$key[0]][$key[1] - 1] = "j";
        }
        updateBDD($tableau);
    }

    function droite($tableau)
    {
        $key = findPlayer($tableau);
        if ($tableau[$key[0]][$key[1] + 1] == "w") {
            $tableau[$key[0]][$key[1]] = "v";
            $tableau[$key[0]][$key[1] + 1] = "j";
            victory($tableau);
        }
        if ($tableau[$key[0]][$key[1] + 1] == "v") {
            $tableau[$key[0]][$key[1]] = "v";
            $tableau[$key[0]][$key[1] + 1] = "j";
        }
        updateBDD($tableau);
    }

    function resetGame($tableau)
    {
        $tableau = [];
        $fp = fopen('levels/' . $_SESSION['level'] . ".txt", 'r');
        if (!$fp) {
            echo "Impossible d'ouvrir le fichier save.txt";
        }

        while (false !== ($line = fgets($fp))) {
            $tableau[] = str_split($line);
        }

    }

    function printTableau($tableau)
    {
        // var_dump($tableau);
        echo '<br>';
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
                if ($subcase == "w") {
                    echo "∏";
                }
            }
            echo  "<br>";
        }
    }

    function tryFillTableau($tableau)
    {
        $fp = fopen('levels/' . $_SESSION['level'] . ".txt", 'r');
        if (!$fp) {
            echo "Impossible d'ouvrir le fichier save.txt";
        }
        if ($tableau == []) {
            while (false !== ($line = fgets($fp))) {
                $tableau[] = str_split($line);
            }
        }
    }

    function victory($tableau)
    {
        resetGame($tableau);
        header("Location: http://caphp/labyrinth/victory");
    }

    function updateBDD($tableau)
    {
        global $mysqli;
        $height = 0;
        foreach($tableau as $line){
            $query = "DELETE FROM maze_line WHERE id_labyrinthe=" . $_SESSION['id'];
            $mysqli->query($query);
        }
        foreach($tableau as $line){
            $strline = implode($line);
            $query = "INSERT INTO maze_line (id_labyrinthe, height, line, nickname_id) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ssss", $_SESSION['id'], $height, $strline, $_SESSION['id']);
            $stmt->execute();
            $height++;
        }
    }




    ?>
    </pre>
    <form method="post">
        <div class="block"> <input type="submit" name="haut" class="button" value="haut" /></div>
        <input type="submit" name="gauche" class="button" value="gauche" />
        <input type="submit" name="bas" class="button" value="bas" />
        <input type="submit" name="droite" class="button" value="droite" />
        <div class="block">
            <br> <br>
            <input type="submit" name="reset" class="button" value="retourner au début" />
        </div>
        <input type="text" name="pseudo" /></div>
        <input type="submit" name="pseudoValidation" class="button" value="changer de pseudo" />
        votre pseudo actuel est <?php echo $pseudo; ?>
        <br><br>
        <input type="submit" name="mainmenu" class="button" value="retour au menu principal" />
    </form>

    <script>
        document.addEventListener('keydown', function(event) {
            if (event.keyCode == 37) {
                <?php gauche($tableau); ?>;
            } else if (event.keyCode == 38) {
                <?php haut($tableau); ?>;
            } else if (event.keyCode == 40) {
                <?php bas($tableau); ?>;
            } else if (event.keyCode == 39) {
                <?php droite($tableau); ?>;
            }
        });
    </script>
</body>

</html>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>labyrinthe</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
    <?php
    session_start();

    $mysqli = new mysqli("localhost:3306", "root", "", "phpLabyrinthe");
    
    if ($mysqli->connect_errno) {
        printf("Échec de la connexion : %s\n", $mysqli->connect_error);
        exit();
    }




    $_SESSION['previous_location'] = 'homepage';
    if (array_key_exists('validation', $_POST)) {
        if ($_POST['pseudo'] == "") {
            echo "ERREUR: vous n'avez pas entré de pseudo <br>";
        } else {
            $pseudo = $_POST['pseudo'];
            if (isset($_POST['taille']))
            {
                if ($_POST['taille'] == 'petit') $_SESSION['level'] = 'level1';
                if ($_POST['taille'] == 'moyen') $_SESSION['level'] = 'level2';
                if ($_POST['taille'] == 'immense') $_SESSION['level'] = 'level3';
                if ($_POST['taille'] == 'custom'){
                    $_SESSION['level'] = 'customlevel';
                    require_once './generation.php';
                    $x = $_POST['largeur'];
                    $y = $_POST['hauteur'];
            
                    $maze = new Generation((int) $x, (int) $y);
                    $maze->generate();
                    $maze->saveToFile();
                }
                if ($result = $mysqli->query("SELECT DISTINCT id_labyrinthe FROM maze_line ORDER BY id_labyrinthe DESC LIMIT 1")) {
                    $_SESSION['id'] = 1;
                    while ($row = $result->fetch_assoc()){
                        $_SESSION['id'] = (int)$row['id_labyrinthe'] +1;
                        
                    } 
                }

                $query = "INSERT INTO nickname (id, name) VALUES (?, ?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ss", $_SESSION['id'], $pseudo);
                if ($stmt->execute() === FALSE) {
                    echo "Error: " . $query . "<br>" . $mysqli->error ."<br>";
                  };


                header("Location: http://caphp/labyrinth/game");
            } else{
                echo "ERREUR: vous n'avez pas choisi votre niveau de difficulté <br>";
            }

        }
    }
    ?>
    Choisissez votre pseudo puis cliquez sur valider:
    <form method="post">
        <div class="block"> <input type="text" name="pseudo" /></div>
        <div class="block"> <input type="submit" name="validation" class="button" value="valider" /></div>
        <div>
            <input type="radio" name="taille" value="petit" />
            <label for="petit">petit</label>
        </div>
        <div>
            <input type="radio" name="taille" value="moyen" />
            <label for="moyen">moyen</label>
        </div>
        <div>
            <input type="radio" name="taille" value="immense" />
            <label for="immense">immense</label>
        </div>
        <div>
            <input type="radio" name="taille" value="custom" />
            <label for="custom">custom:</label>
        </div>
        <div>
            <label for="hauteur">hauteur</label>
            <input type="range" min="5" max="100" value="30" class="slider" id="heightRange" name="hauteur">
            <p>Value: <span id="heightValue"></span></p>
        </div>
        <div>
            <label for="largeur">largeur</label>
            <input type="range" min="5" max="100" value="50" class="slider" id="widthRange" name="largeur">
            <p>Value: <span id="widthValue"></span></p>
        </div>
    </form>
    <script>
        var heightSlider = document.getElementById("heightRange");
        var heightOutput = document.getElementById("heightValue");
        var widthSlider = document.getElementById("widthRange");
        var widthOutput = document.getElementById("widthValue");
        heightOutput.innerHTML = heightSlider.value;
        widthOutput.innerHTML = widthSlider.value;

        heightSlider.oninput = function() {
            heightOutput.innerHTML = this.value;
        }

        widthSlider.oninput = function() {
            widthOutput.innerHTML = this.value;
        }
    </script>
</body>

</html>
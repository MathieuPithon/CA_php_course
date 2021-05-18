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
    $_SESSION['previous_location'] = 'homepage';
    if (array_key_exists('validation', $_POST)) {
        if ($_POST['pseudo'] == "") {
            echo "ERREUR: vous n'avez pas entré de pseudo <br>";
        } else {

            if (isset($_POST['taille']))
            {
                $_SESSION['pseudo'] = $_POST['pseudo'];
                $_SESSION['nb_objets'] = $_POST['objets'];
                $_SESSION['nb_objets_restant'] = $_POST['objets'];
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
            <label for="objets">nombre d'objet à ramasser</label>
            <input type="range" min="0" max="100" value="0" class="slider" id="objects" name="objets" style="width: 300px;">
            <p>Value: <span id="objectNb"></span></p>
        </div>
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
            <input type="range" min="5" max="100" value="30" class="slider" id="heightRange" name="hauteur" style="width: 300px;">
            <p>Value: <span id="heightValue"></span></p>
        </div>
        <div>
            <label for="largeur">largeur</label>
            <input type="range" min="5" max="100" value="50" class="slider" id="widthRange" name="largeur" style="width: 300px;">
            <p>Value: <span id="widthValue"></span></p>
        </div>
    </form>
    <script>
        var heightSlider = document.getElementById("heightRange");
        var heightOutput = document.getElementById("heightValue");
        var widthSlider = document.getElementById("widthRange");
        var widthOutput = document.getElementById("widthValue");
        var objectSlider = document.getElementById("objects");
        var objectOutput = document.getElementById("objectNb");
        heightOutput.innerHTML = heightSlider.value;
        widthOutput.innerHTML = widthSlider.value;
        objectOutput.innerHTML = objectSlider.value;

        objectSlider.oninput = function() {
            objectOutput.innerHTML = this.value;
        }

        heightSlider.oninput = function() {
            heightOutput.innerHTML = this.value;
        }

        widthSlider.oninput = function() {
            widthOutput.innerHTML = this.value;
        }
    </script>
</body>

</html>
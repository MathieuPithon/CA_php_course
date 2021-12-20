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

            if (isset($_POST['taille'])) {
                $_SESSION['pseudo'] = $_POST['pseudo'];
                $_SESSION['nb_objets'] = $_POST['objets'];
                $_SESSION['nb_objets_restant'] = $_POST['objets'];
                if ($_POST['taille'] == 'petit') {
                    $x = 10;
                    $y = 5;
                }
                if ($_POST['taille'] == 'moyen') {
                    $x = 20;
                    $y = 10;
                }
                if ($_POST['taille'] == 'grand') {
                    $x = 30;
                    $y = 15;
                }
                if ($_POST['taille'] == 'custom') {
                    $x = $_POST['largeur'] / 2;
                    $y = $_POST['hauteur'] / 2;
                }
                $_SESSION['level'] = 'customlevel';
                require_once './generation.php';
                $maze = new Generation((int) $x, (int) $y);
                $maze->generate();
                $maze->saveToFile();

                header("Location: http://caphp/labyrinth/game");
            } else {
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
            <label for="petit">petit (10x20)</label>
        </div>
        <div>
            <input type="radio" name="taille" value="moyen" />
            <label for="moyen">moyen (20x40)</label>
        </div>
        <div>
            <input type="radio" name="taille" value="grand" />
            <label for="grand">grand (30x60)</label>
        </div>
        <div>
            <input type="radio" name="taille" value="custom" checked />
            <label for="custom">custom:</label>
        </div>
        <div>
            <label for="hauteur">hauteur</label>
            <input type="range" min="4" max="200" value="60" class="slider" id="heightRange" name="hauteur" style="width: 300px;">
            <p>Value: <span id="heightValue"></span></p>
        </div>
        <div>
            <label for="largeur">largeur</label>
            <input type="range" min="4" max="200" value="100" class="slider" id="widthRange" name="largeur" style="width: 300px;">
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
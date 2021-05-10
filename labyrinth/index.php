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
    session_start();
    $_SESSION['previous_location'] = 'homepage';
    if (array_key_exists('validation', $_POST)) {
        if ($_POST['pseudo'] == "") {
            echo "ERREUR: vous n'avez pas entré de pseudo <br>";
        } else {
            $_SESSION['pseudo'] = $_POST['pseudo'];
            if (isset($_POST['taille']))
            {
                if ($_POST['taille'] == 'petit') $_SESSION['level'] = 'level1';
                if ($_POST['taille'] == 'moyen') $_SESSION['level'] = 'level2';
                if ($_POST['taille'] == 'immense') $_SESSION['level'] = 'level3';
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

    </form>
</body>

</html>
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
    if (array_key_exists('validation', $_POST)) {
        if ($_POST['pseudo'] == "") {
            echo "ERREUR: vous n'avez pas entré de pseudo <br>";
        } else {
            $_SESSION['pseudo'] = $_POST['pseudo'];
            if (isset($_POST['difficulty']))
            {
                if ($_POST['difficulty'] == 'facile') $_SESSION['level'] = 'level1';
                if ($_POST['difficulty'] == 'difficile') $_SESSION['level'] = 'level2';
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
            <input type="radio" name="difficulty" value="facile" />
            <label for="facile">facile</label>
        </div>
        <div>
            <input type="radio" name="difficulty" value="difficile" />
            <label for="difficile">difficile</label>
        </div>

    </form>
</body>

</html>
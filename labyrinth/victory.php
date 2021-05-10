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
    $_SESSION['previous_location'] = 'victory_page';
    echo "félicitation " . $_SESSION["pseudo"] . ", vous avez gagné!!";
    if (array_key_exists('back', $_POST)) {
        header("Location: http://caphp/labyrinth/index");
    }


    ?>
    <form method="post">
        <div>
            <div class="block"> <input type="submit" name="back" class="button" value="back to main menu" /></div>
        </div>
    </form>
</body>
</html>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Labyrinthe-Victoire</title>
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
    $_SESSION['previous_location'] = 'victory_page';
    echo "félicitation " . $_SESSION["pseudo"] . ", vous avez gagné!!";
    if (array_key_exists('back', $_POST)) {
        header("Location: http://caphp/labyrinth/index");
    }


    $result = $mysqli->query("SELECT * FROM nickname");

    while ($row = $result->fetch_assoc()){
        
        $query = "DELETE FROM nickname";
        $mysqli->query($query);
    }
    // $result = $mysqli->query("SELECT * FROM maze_line");

    // while ($row = $result->fetch_assoc()){
        
    //     $query = "DELETE FROM maze_line";
    //     $mysqli->query($query);
    // }
    ?>
    <form method="post">
        <div>
            <div class="block"> <input type="submit" name="back" class="button" value="back to main menu" /></div>
        </div>
    </form>
</body>
</html>
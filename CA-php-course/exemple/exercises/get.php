<?php

echo("get.php");

// Superglobales
// $_GET
// $_POST

echo("<br>");
echo("<br>");
var_dump($_POST);
echo("<br>");
echo("<br>");
// echo("<br>");

// http://localhost/.../get.php?nom=toto&famille=debilos
// var_dump($_GET);

// Requêtes HTTP
// GET : appel d'une page via URL en mode "récupération d'informations"
// POST : envoie d'informations sur une URL
// PUT : similaire au POST, mais dans une sémantique de modification
// DELETE : similaire au POST, mais dans une sémantique de suppression

$mysqli = new mysqli("localhost:3306", "root", "", "ca_php_course");

if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}

function insertJoke($mysqli, $nom) {
	$sql = "INSERT INTO marque (nom) VALUES ('".$nom."')";

	if ($mysqli->query($sql) == TRUE) {
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}
}

function getJokes($mysqli) {
	$noms = [];
	if ($result = $mysqli->query("SELECT * FROM marque")) {
		while ($row = $result->fetch_assoc()) {
			$noms[] = $row["nom"];
		}
	    $result->close();
	}
	return $noms;
}

// On vérifie si le formulaire à été envoyé
if ( isset($_POST) && !is_null($_POST) && !empty($_POST) ) {
	
	// on vérifier si c'est le form goodjoke
	if(isset($_POST["goodjoke"])) {

		// vérification contenu à insérer en BDD
		if(!is_null($_POST["joke"]) && !empty($_POST["joke"])) {
			// AJOUT EN BDD
			insertJoke($mysqli, $_POST["joke"]);
		}

	}

	// on vérifie si c'est le form badjoke
	if(isset($_POST["badjoke"])) {

		// vérification contenu à insérer en BDD
		if(!is_null($_POST["joke"]) && !empty($_POST["joke"])) {
			// AJOUT EN BDD
			insertJoke($mysqli, $_POST["joke"]);
		}	

	}

}

?>
<html>
<head>
	<title>test</title>
</head>
<body>
	<div>
		<?php if(!is_null($_GET["nom"])): ?>
			<p>Salut <?php echo($_GET["nom"]); ?> !</p>
		<?php endif; ?>
		<a href="?nom=toto" title="toto">toto</a>
		<a href="?nom=tata" title="tata">tata</a>
		<a href="?nom=tutu" title="tutu">tutu</a>
		<a href="" title="ICI">ICI</a>
	</div>

	<div>
		<h2>Liste des blagues</h2>
		<?php
			$jokes = getJokes($mysqli);
		?>
		<ul>
			<?php foreach($jokes as $joke): ?>
				<li>
					<?php echo ($joke); ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<h2>ajouter une blague</h2>
		<form action="" method="POST">
			<input type="text" name="joke">
			<button type="submit" name="goodjoke">Ajouter la blague</button>
		</form>

		<form action="" method="POST">
			<input type="text" name="joke">
			<button type="submit" name="badjoke">Ajouter la mauvaise blague</button>
		</form>

	</div>

</body>
</html>
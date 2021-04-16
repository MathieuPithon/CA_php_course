<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>
</head>
<body>
<h1> un tableau</h1>
<?php
		$tableau1 = [
			"a",
			"b",
			"c",
			"d"
		];
	?>
	<span>Mon tableau contient : </span><br>
	<pre>
		<code>
			<?php
				var_dump($tableau1);
			?>
		</code>
	</pre>
	<span>Affichage avec une boucle</span><br>
	<?php
		foreach($tableau1 as $case) {
			echo($case) . "<br>";
		}
	?>
	<span>Clés / valeurs</span>
	<?php
		$tableau2 = [
			"a" => "tata",
			"b" => "tbtb",
			"c" => "tctc",
			"d" => "tdtd"
		];
	?>
	<span>Mon tableau contient : </span><br>
	<pre>
		<code>
			<?php
				var_dump($tableau2);
			?>
		</code>
	</pre>
	<?php
		foreach($tableau2 as $key => $case) {
			echo($key . " => " . $case) . "<br>";
		}
	?>
	<h3>multidimensionnels</h3>
	<?php
		$tableau3 = [
			["a", "a", "a"],
			["b"]
		];
	?>
	<pre>
		<code>
			<?php
				var_dump($tableau3);
			?>
		</code>
	</pre>
	<span>avec un foreach : </span><br>
	<?php
		foreach($tableau3 as $case) {
			foreach($case as $subcase) {
				echo($subcase) . "<br>";
			}
		}
	?>
</body>
</html>
<?php
$mysqli = new mysqli("localhost:3306", "root", "", "ca_php_course");

if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}


$sql = [
    "renault",
    "toyota",
    "peugeot",
    "mitsubishi"
    ];
foreach($sql as $marque) {
    $query = "INSERT INTO marque (nom) VALUES (?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $marque);
    if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $query . $marque . "<br>" . $mysqli->error ."<br>";
      };

}

if ($result = $mysqli->query("SELECT * FROM marque")) {
    $marques = array();
	echo("<table border=\"1\"><thead><tr><td>id</td><td>nom</td></tr></thead><tbody>");
	while ($row = $result->fetch_assoc()) {
		echo("<tr>");
		echo("<td>" . $row["id"] . "</td>");
		echo("<td>" . $row["nom"] . "</td>");
        $marques[] = $row["nom"];
		echo("</tr>");
	}

}
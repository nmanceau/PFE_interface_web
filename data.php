<?php
header('Content-Type: application/json');
// Inclusion du fihcier de connexion à la base de données
include('includes/connexion_bd.php');

// Récupération du numéro de série de la sonde sélectionée
$serialNumber_choix = $_POST['choix'];
// Requête récupérant les 50 dernières informations d'une sonde
$sqlQuery = "SELECT type, serialNumber, measurement, dateTimeCreated, location from tbl_message WHERE (serialNumber = $serialNumber_choix) ORDER BY dateTimeCreated asc LIMIT 50";
// Execution de la requête
$result = mysqli_query($connect,$sqlQuery);

// Construction d'un tableau avec les informations
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

// Fermture de la connexion
mysqli_close($connect);
// Ecriture du tableau dans le JSON
echo json_encode($data);
?>

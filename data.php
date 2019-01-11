<?php
header('Content-Type: application/json');
include('includes/connexion_bd.php');

// Connection à la base de donnée
$connect = mysqli_connect($host_name, $user_name, $password, $database);
$serialNumber_choix = $_POST['choix'];
$sqlQuery = "SELECT type, serialNumber, measurement, dateTimeCreated, location from tbl_message WHERE (serialNumber = $serialNumber_choix) ORDER BY dateTimeCreated asc LIMIT 50";

$result = mysqli_query($connect,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($connect);
echo json_encode($data);
?>

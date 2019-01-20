<?php
// connexion à la base des données :
include("includes/connexion_bd.php");

// Indication au navigateur que l'on va exporter un CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename='.$_GET['nom_table'].'.csv');

// Seléection de la table à exporter
$select_table = mysqli_query($connect,'select * from '.$_GET['nom_table']);

$rows = mysqli_fetch_assoc($select_table);

if($rows) {
  makecsv(array_keys($rows));
}
while($rows) {
  makecsv($rows);
  $rows = mysqli_fetch_assoc($select_table);
}

function makecsv($num_field_names) {
  $separate = '';
  // on formate les données pour remplacer les séparateurs par des traits d’union
  foreach ($num_field_names as $field_name) {
    $field_name = str_replace( array('',' ', '\n ', ' \r ', ' ; '), array( '-', '-', '-', '-', ','), $field_name);
    echo $separate . $field_name;
    // on insère un séparateur de champ reconnu par Excel
    $separate = ';';
  }
  // nouvelle rangée, nouvelle ligne
  echo "\n";
}
?>

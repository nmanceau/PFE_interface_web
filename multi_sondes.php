<?php
// Démarrage de la session
session_start();

if($_SESSION["name"] != ""){
// Inclusion du fichier d'en tête
include('includes/header.php');
?>

<!-- Page Content  -->
<div id="content">
  <h1 class="my-4 text-center">Multi sondes :</h1>
  <!-- row -->
  <div class="row">
    <?php
    // Recherche tous les numéros de série différents dans la base de donnnées
    $result_sn = mysqli_query($connect,"SELECT DISTINCT serialNumber from tbl_message");

    // Lecture de chaque ligne dans la base de données
    while ($row_sn = mysqli_fetch_array($result_sn)) {
      $serialNumber_id = $row_sn['serialNumber'];
      // Récupération des informations d'une sonde
      $result = mysqli_query($connect,'SELECT type, serialNumber, measurement, location, DATE_FORMAT(dateTimeCreated, \'%d/%m/%Y à %H:%i:%s\') AS dateTimeCreatedFormat from tbl_message WHERE (serialNumber = '.$serialNumber_id.') ORDER BY dateTimeCreated asc');

      // Lecture de chaque ligne dans la base de données
      while ($row = mysqli_fetch_array($result)) {
        $serialNumber = $row["serialNumber"];
        $type = $row["type"];
        $measurement = $row["measurement"];
        $dateTimeCreated = $row["dateTimeCreatedFormat"];
        $location = $row["location"];
        $location = trim($location);
      }

      //Affichage dynamique des tableau contneant les informations des sondes
      echo"
      <div class=\"col-lg-6 portfolio-item\">
      <div class=\"card h-100 table_shadow\">
      <table class=\"table-multi table-bordered table-responsive text-center table_perso\" margin=\"2%\">
      <tbody>
      <tr>
      <th scope=\"row\">Type :</th>
      <td>
      <input readonly=\"true\" class=\"no-border\" type=\"text\" name=\"type\" value=".$type.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Numéro de série : </th>
      <td>
      <input readonly=\"true\" class=\"no-border\" type=\"text\" name=\"sn\" value=".$serialNumber.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Mesure en cps : </th>
      <td>
      <input readonly=\"true\" class=\"no-border\" type=\"text\" name=\"mesure\" value=".$measurement.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Localisation : </th>
      <td>
      <input readonly=\"true\" class=\"no-border\" type=\"text\" name=\"localisation\" value=".$location.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Date crée : </th>
      <td>
      <input readonly=\"true\" class=\"no-border\" type=\"text\" name=\"date\" value='$dateTimeCreated'>
      </td>
      </tr>
      </tbody>
      </table>
      </div>
      </div>";
    }
    ?>
  </div>
  <!-- /.row -->
  <br/>
</div>
<!-- /.Page Content  -->

<?php
// Fermeture de la connection mysql
mysqli_close($connect);
// Inclusion du fichier de bas de page
include('includes/footer.php');
}
?>

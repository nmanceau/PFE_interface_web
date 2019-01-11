<?php
include('includes/header.php');
//include('connexion_bd.php');
?>

<!-- Page Content  -->
<div id="content">
  <h1 class="my-4 text-center">Multi sondes :</h1>
  <div class="row">
    <?php
    // Recherche toutes les numéros de série différents dans base de donnnées
    $res_sn = $connect->query("SELECT DISTINCT serialNumber from tbl_message");

    // Lecture de chaque ligne dans la base de donnée
    while ($row_sn = mysqli_fetch_array($res_sn)) {
      $serialNumber_id = $row_sn['serialNumber'];
      // Lecture Base de donnée
      $res = $connect->query('SELECT type, serialNumber, measurement, location, DATE_FORMAT(dateTimeCreated, \'%d/%m/%Y à %H:%i:%s\') AS dateTimeCreatedFormat from tbl_message WHERE (serialNumber = '.$serialNumber_id.') ORDER BY dateTimeCreated desc');

      // Lecture de chaque ligne dans la base de donnée
      while ($row = mysqli_fetch_array($res)) {
        $serialNumber = $row["serialNumber"];
        $type = $row["type"];
        $measurement = $row["measurement"];
        $dateTimeCreated = $row["dateTimeCreatedFormat"];
        $location = $row["location"];
        $location = trim($location);
      }

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
      <th scope=\"row\">Coordonées : </th>
      <td>
      <input readonly=\"true\" class=\"no-border\" type=\"text\" name=\"coordonnees\" value=".$location.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Date crée : </th>
      <td>
      <input readonly=\"true\" class=\"no-border\" type=\"text\" name=\"coordonnees\" value='$dateTimeCreated'>
      </td>
      </tr>
      </tbody>
      </table>
      </div>
      </div>";
    }
    ?>
  </div>
  <br/>
  <!-- /.row -->
</div>
<!-- /.container -->

<?php
// Fermeture de la connection mysql
mysqli_close($connect);
include('includes/footer.php');
?>

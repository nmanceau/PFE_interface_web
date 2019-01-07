<?php
include('includes/header.php');
//include('connexion_bd.php');
?>
<!-- Page Content  -->
<div id="content">
  <div id="page-content-wrapper">
    <div class="container">
      <?php
      $adresse = $_SERVER['PHP_SELF'];
      $i = 0;
      foreach($_GET as $cle => $valeur){
        $adresse .= ($i == 0 ? '?' : '&').$cle.($valeur ? '='.$valeur : '');
        $i++;
      }

      if($adresse != "/git_PFE/mono_sonde.php"){
        $serialNumber_choix = $_GET["choix_serialNumber"];
        // Lecture Base de donnée
        $res = $connect->query("SELECT type, serialNumber, measurement, dateTimeCreated, location from tbl_message WHERE (serialNumber = '$serialNumber_choix') ORDER BY dateTimeCreated desc");

        // Lecture de chaque ligne dans la base de donnée
        while ($row = mysqli_fetch_array($res)) {
          $serialNumber = $row["serialNumber"];
          $type = $row["type"];
          $measurement = $row["measurement"];
          $dateTimeCreated = $row["dateTimeCreated"];
          $location = $row["location"];
          $location = trim($location);
        }

        // Fermeture de la connection mysql
        mysqli_close($connect);
      }else{
        $serialNumber ="";
        $type = "";
        $measurement = "";
        $dateTimeCreated = "";
        $location = "";
      }
      echo"
      <div class=\"row justify-content-md-center\">
      <div class=\"col-lg-6 col-lg-offset-3 portfolio-item\">
      <h1 class=\"my-4 title_table\">Mono sonde :</h1>
      <div class=\"card h-60 table_shadow\">
      <table class=\"table-bordered thead-dark text-center\">
      <tbody>
      <tr>
      <th scope=\"row\">Type :</th>
      <td>
      <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"type\" value=".$type.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Numéro de série : </th>
      <td>
      <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"sn\" value=".$serialNumber.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Mesure en cps : </th>
      <td>
      <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"mesure\" value=".$measurement.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Coordonées : </th>
      <td>
      <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"coordonnees\" value=".$location.">
      </td>
      </tr>
      <tr>
      <th scope=\"row\">Date crée : </th>
      <td>
      <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"coordonnees\" value=".$dateTimeCreated.">
      </td>
      </tr>
      </tbody>
      </table>
      </div>
      </div>
      </div>";
      ?>
    </div>
  </div>
</div>

<?php
include('includes/footer.php');
?>
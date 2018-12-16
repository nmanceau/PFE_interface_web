<?php
include('header.php');

// Variable de connexion à la base de donnée
$host_name = "localhost";
$database = "mydb";
$user_name = "user";
$password = "user";

// Connection à la base de donnée
$connect = mysqli_connect($host_name, $user_name, $password, $database);
?>
<!-- Page Content  -->
<div id="content">

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
  <!-- Page Content -->
  <div id=\"page-content-wrapper\">
  <div class=\"container\">
  <h1 class=\"my-4 title_table\">Sonde CSP</h1>

  <table class=\"table table-bordered thead-dark text-center\">
  <tbody>
  <tr>
  <th scope=\"row\">Type :</th>
  <td>
  <input readonly=\"true\" type=\"text\" name=\"type\" value=".$type.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Numéro de série : </th>
  <td>
  <input readonly=\"true\" type=\"text\" name=\"sn\" value=".$serialNumber.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Mesure en cps : </th>
  <td>
  <input readonly=\"true\" type=\"text\" name=\"mesure\" value=".$measurement.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Coordonées : </th>
  <td>
  <input readonly=\"true\" type=\"text\" name=\"coordonnees\" value=".$location.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Date crée : </th>
  <td>
  <input readonly=\"true\" type=\"text\" name=\"coordonnees\" value=".$dateTimeCreated.">
  </td>
  </tr>
  </tbody>
  </table>
  </div>
  </div>";

  ?>
</div>
</div>

<?php
include('footer.php');
?>

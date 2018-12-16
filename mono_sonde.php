<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mise en place de sondes connectées</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
  <!-- Custom styles for this template -->
  <link href="css/2-col-portfolio.css" rel="stylesheet">

</head>

<?php
// Variable de connexion à la base de donnée
$host_name = "localhost";
$database = "mydb";
$user_name = "user";
$password = "user";

// Connection à la base de donnée
$connect = mysqli_connect($host_name, $user_name, $password, $database);
?>

<body class = "bg-blue">
  <div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <br />
        <h3>Paramètres</h3>
      </div>

      <ul class="list-unstyled components">
        <li>
          <a href="mono_sonde.php">Accueil</a>
        </li>
        <br />
        <li class="active">
          <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Mono sonde</a>
          <ul class="collapse list-unstyled" id="homeSubmenu">
            <li>
              <form method="GET" action="mono_sonde.php">
                <div class="form-group">
                  <br/>
                  <label for="choix_serialNumber">Choix de la sonde : </label>
                  <select class="form-control" name="choix_serialNumber" onchange="this.form.submit()">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <?php
                    // Lecture Base de donnée
                    $res = $connect->query("SELECT DISTINCT serialNumber from tbl_message");
                    // Lecture de chaque ligne dans la base de donnée
                    while ($row = mysqli_fetch_array($res)) {
                      $sn = $row["serialNumber"];
                      echo  "<option value ="."$sn".">"."$sn"."</option>";
                    }
                    ?>
                  </select>
                </div>
              </form>
            </li>
          </ul>
        </li>
        <br />
        <li>
          <a href="multi_sondes.php">Multi sondes</a>
        </li>
      </ul>
    </nav>

    <div class="style_nav">
      <nav class="navbar navbar-dark bg-orange fixed-top ">
        <button type="button" id="sidebarCollapse" class="btn btn_blue">
          <img  alt="Logo" src="files/menu1.png" width ="20%" class="pull-left">
        </button>
        <div class="mx-auto order-0">
          <a class="navbar-brand title_page" href="http://www.canberra.com/fr/" target="_blank">Sondes CSP connectées
            <img style=" **margin-top: -55px;**" width="30%" alt="Logo" src="files/Mirion_Tech.jpg" >
          </a>
        </div>
      </nav>
    </div>

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

  <!-- jQuery CDN - Slim version (=without AJAX) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <!-- Popper.JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

  <script type="text/javascript">
  $(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
    });
  });
  </script>
</body>
</html>

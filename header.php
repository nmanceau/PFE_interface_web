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

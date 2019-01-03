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

  <!-- Custom styles for this template -->
  <link href="css/template.css" rel="stylesheet">
  <link href="css/user.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>

<?php
include('connexion_bd.php');
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
        <li class="active">
          <li>
            <a href="multi_sondes.php">Multi sondes</a>
          </li>
        </li>
      </ul>
    </nav>

    <div class="style_nav">
      <nav class="navbar navbar-dark bg-orange fixed-top ">
        <i class="fas fa-align-justify pull-left" id="sidebarCollapse" style='font-size:110%'></i>
        <div class="mx-auto order-0 h1_responsive">
          <a class="navbar-brand title_page" href="http://www.canberra.com/fr/" target="_blank">Sondes CSP connectées
            <img class="pull_right" style=" **margin-top: -55px;**" width="30%" height="auto" alt="Logo" src="files/Mirion_Tech.jpg" >
          </a>
        </div>
      </nav>
    </div>

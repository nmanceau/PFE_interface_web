<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mise en place de sondes connectées</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- Custom styles for this template -->
  <link href="css/template.css" rel="stylesheet">
  <link href="css/user.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/Chart.min.js"></script>
</head>

<?php
// Inclusion du fichier de connexion à la base de données
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
                    // Récupération des numéros de série de toutes les sondes pour les afficher dans le menu
                    $result = mysqli_query($connect,"SELECT DISTINCT serialNumber from tbl_message");
                    // Lecture de chaque ligne dans la base de données
                    while ($row = mysqli_fetch_array($result)) {
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
      </li>
      <br />
      <li class="active">
        <li>
          <a href="multi_sondes.php">Multi sondes</a>
        </li>
      </ul>
    </nav>
    <!-- /.Sidebar  -->

    <nav class="navbar navbar-dark bg-orange fixed-top ">
      <i class="fas fa-align-justify pull-left menu" id="sidebarCollapse"></i>
      <div class="mx-auto order-0">
        <a class="navbar-brand title_page" href="multi_sondes.php">Sondes CSP connectées</a>
      </div>
      <?php
      // Gestion de la connection
      if($_SESSION["name"] != ""){
        echo "
        <li class=\"nav-link link_perso\">".$_SESSION["name"]."
        </li>
        <a class=\"nav-link link_perso\" href=\"deconnexion.php\">Se déconnecter</a>";
      }
      ?>
    </nav>

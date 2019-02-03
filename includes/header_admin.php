<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Mise en place de sondes connectées</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- Custom styles for this template -->
  <link href="css/template.css" rel="stylesheet">
  <link href="css/admin.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

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
        <li class="active">
          <li>
            <a href="admin_users.php">Gestion comptes users</a>
          </li>
        </li>
        <br/>
        <li>
          <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Gestion base données</a>
          <ul class="collapse list-unstyled" id="homeSubmenu">
            <li>
              <form method="GET" action="admin_bd.php">
                <div class="form-group">
                  <br/>
                  <label for="choix_serialNumber">Fonctionnalités : </label>
                  <select class="form-control" name="choix_fonct" onchange="this.form.submit()">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <option value ="visualiser_bd">Visualiser base de données</option>";
                    <option value ="visualiser_parc">Visualiser parc</option>";
                    <option value ="modifier">Modifier base de données</option>";
                  </select>
                </div>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.Sidebar  -->

    <div class="style_nav">
      <nav class="navbar navbar-dark bg-orange fixed-top ">
        <i class="fas fa-align-justify pull-left" id="sidebarCollapse" style='font-size:110%'></i>
        <div class="mx-auto order-0">
          <a class="navbar-brand title_page" href="admin_users.php">Sondes CSP connectées</a>
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
    </div>

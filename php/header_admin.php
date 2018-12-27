<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mise en place de sondes connectées</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../css/style.css">
  <!-- Custom styles for this template -->
  <link href="../css/2-col-portfolio.css" rel="stylesheet">
  <link href="../css/admin.css" rel="stylesheet">

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
                  <label for="choix_serialNumber">Fonctionnalitées : </label>
                  <select class="form-control" name="choix_fonct" onchange="this.form.submit()">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <option value ="visualiser">Visualiser base de données</option>";
                    <option value ="modifier">Modifier base de données</option>";
                  </select>
                </div>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </nav>

    <div class="style_nav">
      <nav class="navbar navbar-dark bg-orange fixed-top ">
        <button type="button" id="sidebarCollapse" class="btn btn_blue">
          <img  alt="Logo" src="../files/menu1.png" width ="20%" class="pull-left">
        </button>
        <div class="mx-auto order-0">
          <a class="navbar-brand title_page" href="http://www.canberra.com/fr/" target="_blank">Sondes CSP connectées
            <img style=" **margin-top: -55px;**" width="30%" alt="Logo" src="../files/Mirion_Tech.jpg" >
          </a>
        </div>
      </nav>
    </div>

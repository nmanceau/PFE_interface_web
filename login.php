<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mise en place de sondes connectées</title>

  <!-- Custom styles for this template -->
  <link href="css/login.css" rel="stylesheet">
  <link href="css/2-col-portfolio.css" rel="stylesheet">
  
  <link href="css/boostrap_perso_login.css" rel="stylesheet">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-orange fixed-top">
    <div class="container">
      <a class="navbar-brand title_page" href="http://www.canberra.com/fr/" target="_blank">Sondes CSP connectées</a>
      <img style=" **margin-top: -55px;**" alt="Logo" src="files/Mirion_Tech.jpg" >
    </div>
  </nav>
</head>

<body class="bg-blue">
  <div class="modal-dialog">
    <div class="loginmodal-container">
      <h1>Login to Your Account</h1><br>
      <form method="post" action="login.php">
        <input type="text" name="login" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="submit" class="login loginmodal-submit" value="Login">
      </form>

      <div class="login-help">
        <a href="#">Register</a> - <a href="mono_sonde.php">Forgot Password</a>
      </div>
    </div>


    <?php
    // Variable de connexion à la base de donnée
    $host_name = "localhost";
    $database = "mydb";
    $user_name = "user";
    $password = "user";

    // Connection à la base de donnée
    $connect = mysqli_connect($host_name, $user_name, $password, $database);

    if(isset($_POST['submit']) AND $_POST['submit']=='Login'){
      // Test si les champs login et password sont mises à 1
      if(isset($_POST["login"]) && isset($_POST["password"])){
        // Initialisation des variables
        $username = $_POST["login"];
        $password = $_POST["password"];

        // Lecture Base de donnée
        $res = $connect->query("SELECT EXISTS (SELECT profil from users WHERE (name = '$username' and password = '$password')) AS user_exists");
        $res->data_seek(0);
        $row = $res->fetch_assoc();

        if ($row['user_exists'] == true) {
          $res = $connect->query("SELECT profil from users WHERE (name = '$username' and password = '$password')");
          $res->data_seek(0);
          $row = $res->fetch_assoc();
          $profil_db = $row['profil'];
        }
        else {
          $profil_db = 0;
        }

        /*
        // Lecture de chaque ligne dans la base de donnée
        while ($row = $res->fetch_assoc()) {
        $profil_db = $row['profil'];
      }
      */

      // User = 1
      if($profil_db == 1){
        header('Location: mono_sonde.php');
        // Admin = 2
      }else if($profil_db == 2){
        header('Location: admin.php');
      }else{
        ?>
        <h1 class ="titre"> Erreur de Connexion </h1>
        <?php
      }

    }
  }

  // Fermeture de la connection mysql
  mysqli_close($connect);
  ?>

</div>
</body>

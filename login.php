<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mise en place de sondes connectées</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/2-col-portfolio.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
</head>

<body class = "bg-blue">
  <div class="style_nav">
    <nav class="navbar navbar-dark bg-orange fixed-top ">
      <div class="mx-auto order-0">
        <a class="navbar-brand title_page" href="http://www.canberra.com/fr/" target="_blank">Sondes CSP connectées
          <img style=" **margin-top: -55px;**" width="30%" alt="Logo" src="files/Mirion_Tech.jpg" >
        </a>
      </div>
    </nav>
  </div>
  <div class="container">
    <div class="row " >
      <div class="col-sm-4">
      </div>
      <div class="col-sm-4">
        <div class="login-form">
          <div class="panel">
            <h2>Please enter your name and password</h2>
            <br />
          </div>
          <form id="Login" method="post" action="login.php">
            <div class="form-group">
              <input type="text" name="login" class="form-control" id="inputEmail" placeholder="Username">
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
            <div class="forgot">
              <a href="reset.html">Forgot password?</a>
            </div>
            <?php
            include('connexion_bd.php');

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
                <div class="panel">
                  <h2>Please re_enter your name and password</h2>
                </div>
                <?php
              }
            }
          }

          // Fermeture de la connection mysql
          mysqli_close($connect);
          ?>
          <button type="submit" name="submit" class="btn btn-primary" value="Login">Login</button>
        </form>
      </div>

    </div>
  </div>
  <div class="col-sm-4">
  </div>
</div>

</body>
</html>

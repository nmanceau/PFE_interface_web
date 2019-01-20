<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mise en place de sondes connectées</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <link href="css/template.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
</head>

<?php
// Inclusion du fichier de connexion à la base de données
include('includes/connexion_bd.php');
// Inclusion di fichier contenant la classe sécurité
include('includes/Securite.php');
?>
<body class = "bg-blue">
  <!-- style_nav  -->
  <div class="style_nav">
    <nav class="navbar navbar-dark bg-orange fixed-top ">
      <div class="mx-auto order-0">
        <a class="navbar-brand title_page" href="http://www.canberra.com/fr/" target="_blank">Sondes CSP connectées
          <img style=" **margin-top: -55px;**" width="30%" alt="Logo" src="files/Mirion_Tech.jpg" >
        </a>
      </div>
    </nav>
  </div>
  <!-- /.style_nav  -->

  <!-- Container -->
  <div class="container">
    <div class="row " >
      <div class="col-sm-4">
      </div>
      <div class="col-sm-4">
        <div class="login-form">
          <div class="panel">
            <h2>Veuillez entrer vos identifiants :</h2>
            <br />
          </div>
          <!-- Formulaire de login -->
          <form id="Login" method="post" action="login.php">
            <div class="form-group">
              <input type="text" name="login" class="form-control" id="inputEmail" placeholder="Username">
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
            <br/>
            <?php
            // Test l'appui sur le bouton submit et test si les champs login et password sont mises à 1
            if(isset($_POST['submit']) && $_POST['submit']=='Login' && isset($_POST["login"]) && isset($_POST["password"])){
              // Initialisation des variables
              $username = $_POST["login"];
              $password = $_POST["password"];

              // Utilisation de l'algorithme bcrypt par défault
              $password_hash = password_hash(trim($password), PASSWORD_DEFAULT);
              // Utilisation de l'affichage du password haché pour entrer en dur le mot de passe hashé en base de données
              // echo $password_hash;

              // Test si l'utilisateur existe déjà dans la base de données
              if($stmt = mysqli_prepare($connect, "SELECT name, password, profil from users WHERE name = ?")){
                // Lecture des paramètres de marques et utilisation de la classe de sécurité
                mysqli_stmt_bind_param($stmt, "s", Securite::bdd($connect,$username));

                // Test et exécution de la requête
                if(!mysqli_stmt_execute($stmt)){
                  printf(mysqli_connect_error());
                }
                // Récupération du password hashé et de l'email
                mysqli_stmt_bind_result($stmt,$nameBdd,$passwordBdd, $profilBdd);
                // Récupération des valeurs
                mysqli_stmt_fetch($stmt);

                // Vérification du mot de passe
                $password_verify = password_verify(trim($password),$passwordBdd);
              }else{
                printf(mysqli_connect_error());
              }

              // Test si l'email de l'utilisateur est en base de données et que son mot de passe est bon
              if ($nameBdd != "" && $password_verify) {
                // Test s'il s'agit d'un profil utilisateur
                if($profilBdd == "utilisateur"){
                  header('Location: multi_sondes.php');
                  // Test s'il s'agit d'un profil administrateur
                }else if($profilBdd == "administrateur"){
                  header('Location: admin_users.php');
                }
                mysqli_stmt_close($stmt);
              }else {
                // Affichage d'un message d'erreur si l'identiant et/ ou mot de passe est faux
                echo "<h4> Votre identifiant et/ou mot de passe est erronées </h4>";
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
  <!-- Container -->

</body>
</html>

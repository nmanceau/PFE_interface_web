<?php
include('includes/header_admin.php');
//include('connexion_bd.php');
?>

<!-- Page Content  -->
<div id="content">
  <h1 class="my-4 text-center">Administration des comptes utilisateurs :
  </h1>
  <div class="row">
    <div class="col-lg-6 portfolio-item">
      <div class="card h-100">
        <h3 class="my-4 title_table text-center">Création d'un utilisateur : </h3>
        <form method="post" action="admin_users.php">
          <table class="table-multi table-bordered thead-dark text-center">
            <tbody>
              <tr>
                <th scope="row">Nom :</th>
                <td>
                  <input type="text" name="name">
                </td>
              </tr>
              <tr>
                <th scope="row">Profil :</th>
                <td>
                  <input type="text" name="profil">
                </td>
              </tr>
              <tr>
                <th scope="row">Mot de passe : </th>
                <td>
                  <input type="password" name="mdp">
                </td>
              </tr>
              <tr>
                <th scope="row">Confirmer mot de passe : </th>
                <td>
                  <input type="password" name="mdp_conf">
                </td>
              </tr>
            </tbody>
          </table>
          <button type="submit" name="enregistrer" value ="Enregistrer" class="btn btn-primary bt_enregistrer ">Enregistrer</button>
        </form>

        <?php

        // on teste la déclaration de nos variables
        if (isset($_POST['enregistrer']) && $_POST['enregistrer']="Enregistrer") {

          if(trim($_POST['name']) != "" && trim($_POST['mdp']) == trim($_POST['mdp_conf'])){
            $name = trim($_POST['name']);
            $mdp = trim($_POST['mdp']);
            $profil = trim($_POST['profil']);

            $res = $connect->query("SELECT EXISTS (SELECT name from users WHERE (name = '$name' and profil = '$profil')) AS user_exists");
            $res->data_seek(0);
            $row = $res->fetch_assoc();

            if ($row['user_exists'] == false) {
              $req_user = $connect->query("INSERT INTO users (name, password, profil) VALUES ('$name','$mdp','$profil')");
              echo "<br/><h4 class=\"text-center\">L'utilisateur a été créé !</h4><br/>";
              $name = "";
              $mdp = "";
              $profil = "";
            }else{
              echo "<br/><h4 class=\"text-center\">L'utilisateur ".$name." existe déjà dans la base de données</h4><br/>";
            }
          }else{
            echo "<br/><h4 class=\"text-center\">Un ou plusieurs champs sont erronées</h4><br/>";
          }
        }
        ?>
      </div>
    </div>

    <div class="col-lg-6 portfolio-item">
      <div class="card h-100">
        <h3 class="my-4 title_table text-center">Modification d'un utilisateur : </h3>
        <form method="post" action="admin_users.php">
          <table class="table-multi table-bordered thead-dark text-center">
            <tbody>
              <tr>
                <th scope="row">Nom :</th>
                <td>
                  <input type="text" name="name">
                </td>
              </tr>
              <tr>
                <th scope="row">Nouveau mot de passe :</th>
                <td>
                  <input type="password" name="mdp">
                </td>
              </tr>
              <tr>
                <th scope="row">Confirmer le nouveau mot de passe : </th>
                <td>
                  <input type="password" name="mdp_conf">
                </td>
              </tr>
            </tbody>
          </table>
          <button type="submit" name="enregistrer_modif" value ="Enregistrer_modif" class="btn btn-primary bt_enregistrer ">Enregistrer</button>
        </form>

        <?php

        // on teste la déclaration de nos variables
        if (isset($_POST['enregistrer_modif']) && $_POST['enregistrer_modif']="Enregistrer_modif") {

          if(trim($_POST['name']) != "" && trim($_POST['mdp']) == trim($_POST['mdp_conf'])){
            $name = trim($_POST['name']);
            $mdp = trim($_POST['mdp']);

            $res = $connect->query("SELECT EXISTS (SELECT name from users WHERE (name = '$name')) AS user_exists");
            $res->data_seek(0);
            $row = $res->fetch_assoc();

            if ($row['user_exists'] == true) {
              $req_user = $connect->query("UPDATE users SET password ='$mdp' WHERE (name = '$name')");
              echo "<br/><h4 class=\"text-center\">Le mot de passe de l'utilisateur ".$name." a été modifié !</h4><br/>";
              $name = "";
              $mdp = "";
            }else{
              echo "<br/><h4 class=\"text-center\">L'utilisateur ".$name." n'existe pas dans la base de données</h4><br/>";
            }
          }else{
            echo "<br/><h4 class=\"text-center\">Un ou plusieurs champs sont erronées</h4><br/>";
          }
        }
        ?>
      </div>
    </div>

    <div class="col-lg-6 portfolio-item">
      <div class="card h-100">
        <h3 class="my-4 title_table text-center">Suppresion d'un utilisateur : </h3>
        <form method="post" action="admin_users.php">
        <table class="table-multi table-bordered thead-dark text-center">
          <tbody>
            <tr>
              <th scope="row">Nom :</th>
              <td>
                <input type="text" name="name">
              </td>
            </tr>
          </tbody>
        </table>
        <button type="submit" name="enregistrer_suppr" value ="Enregistrer_suppr" class="btn btn-primary bt_enregistrer ">Enregistrer</button>
        </form>

        <?php

        // on teste la déclaration de nos variables
        if (isset($_POST['enregistrer_suppr']) && $_POST['enregistrer_modif']="Enregistrer_suppr") {

          if(trim($_POST['name']) != ""){
            $name = trim($_POST['name']);

            $res = $connect->query("SELECT EXISTS (SELECT name from users WHERE (name = '$name')) AS user_exists");
            $res->data_seek(0);
            $row = $res->fetch_assoc();

            if ($row['user_exists'] == true) {
              $req_user = $connect->query("DELETE FROM users WHERE (name = '$name')");
              echo "<br/><h4 class=\"text-center\">L'utilisateur ".$name." a été supprimé !</h4><br/>";
              $name = "";
              $mdp = "";
            }else{
              echo "<br/><h4 class=\"text-center\">L'utilisateur ".$name." n'existe pas dans la base de données</h4><br/>";
            }
          }else{
            echo "<br/><h4 class=\"text-center\">Veuillez entrer le nom de l'utilisateur à supprimer</h4><br/>";
          }
        }
        ?>
      </div>

  </div>
  <!-- /.row -->
</div>
</div>
<!-- /.container -->

<?php
// Fermeture de la connection mysql
mysqli_close($connect);
include('includes/footer_admin.php');
?>

<?php
include('includes/header_admin.php');
?>

<!-- Page Content  -->
<div id="content">
  <h1 class="my-4 text-center h1_responsive">Administration des comptes utilisateurs :
  </h1>
  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3 portfolio-item">
      <div class="card h-100 table_shadow">
        <h3 class="my-4 title_table text-center h3_responsive">Création d'un utilisateur : </h3>
        <form method="post" action="admin_users.php">
          <table class="table-multi table-bordered text-center table-responsive table_perso">
            <tbody>
              <tr>
                <th scope="row">Nom :</th>
                <td>
                  <input class="no-border" type="text" name="name">
                </td>
              </tr>
              <tr>
                <th scope="row">Profil :</th>
                <td>
                  <select class="form-control select_sn" name="choix_profil">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <?php
                    // Lecture Base de données
                    $res = $connect->query("SELECT DISTINCT profil from users");
                    // Lecture de chaque ligne dans la base de donnée
                    while ($row = mysqli_fetch_array($res)) {
                      $profil = $row["profil"];

                      if($profil == 1){
                        $profil = "utilisateur";
                      }else if($profil == 2){
                        $profil = "administrateur";
                      }
                      echo  "<option value ="."$profil".">"."$profil"."</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th scope="row">Mot de passe : </th>
                <td>
                  <input class="no-border" type="password" name="mdp">
                </td>
              </tr>
              <tr>
                <th scope="row">Confirmer mot de passe : </th>
                <td>
                  <input class="no-border" type="password" name="mdp_conf">
                </td>
              </tr>
            </tbody>
          </table>
          <br/>
          <button type="submit" name="enregistrer" value ="Enregistrer" class="btn btn-primary bt_enregistrer ">Enregistrer</button>
        </form>

        <?php
        // on teste la déclaration de nos variables
        if (isset($_POST['enregistrer']) && $_POST['enregistrer']="Enregistrer") {
          if(trim($_POST['name']) != "" && trim($_POST['mdp']) == trim($_POST['mdp_conf'])){
            $name = trim($_POST['name']);
            $mdp = trim($_POST['mdp']);
            $profil = trim($_POST['choix_profil']);

            $res = $connect->query("SELECT EXISTS (SELECT name from users WHERE (name = '$name' and profil = '$profil')) AS user_exists");
            $res->data_seek(0);
            $row = $res->fetch_assoc();

            if (!$row['user_exists']) {
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
  </div>

  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3 portfolio-item">
      <div class="card h-100 table_shadow">
        <h3 class="my-4 title_table text-center h3_responsive">Modification d'un utilisateur : </h3>
        <form method="post" action="admin_users.php">
          <table class="table-multi table-bordered text-center table-responsive table_perso">
            <tbody>
              <tr>
                <th scope="row">Nom :</th>
                <td>
                  <select class="form-control select_sn" name="choix_name">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <?php
                    // Lecture Base de donnée
                    $res = $connect->query("SELECT DISTINCT name from users");
                    // Lecture de chaque ligne dans la base de donnée
                    while ($row = mysqli_fetch_array($res)) {
                      $name = $row["name"];
                      echo  "<option value ="."$name".">"."$name"."</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th scope="row">Nouveau mot de passe :</th>
                <td>
                  <input class="no-border" type="password" name="mdp">
                </td>
              </tr>
              <tr>
                <th scope="row">Confirmer le nouveau mot de passe : </th>
                <td>
                  <input class="no-border" type="password" name="mdp_conf">
                </td>
              </tr>
            </tbody>
          </table>
          <br/>
          <button type="submit" name="enregistrer_modif" value ="Enregistrer_modif" class="btn btn-primary bt_enregistrer bouton_bas">Enregistrer</button>
        </form>

        <?php

        // on teste la déclaration de nos variables
        if (isset($_POST['enregistrer_modif']) && $_POST['enregistrer_modif']="Enregistrer_modif") {
          if(trim($_POST['mdp']) == trim($_POST['mdp_conf'])){
            $name = trim($_POST['choix_name']);
            $mdp = trim($_POST['mdp']);

            $req_user = $connect->query("UPDATE users SET password ='$mdp' WHERE (name = '$name')");
            echo "<br/><h4 class=\"text-center\">Le mot de passe de l'utilisateur ".$name." a été modifié !</h4><br/>";
            $name = "";
            $mdp = "";
          }else{
            echo "<br/><h4 class=\"text-center\">Un ou plusieurs champs sont erronées</h4><br/>";
          }
        }
        ?>
      </div>
    </div>
  </div>

  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3 portfolio-item">
      <div class="card h-100 table_shadow">
        <h3 class="my-4 title_table text-center h3_responsive">Suppresion d'un utilisateur : </h3>
        <form method="post" action="admin_users.php">
          <table class="table-multi table-bordered table-responsive text-center table_perso">
            <tbody>
              <tr>
                <th scope="row">Nom :</th>
                <td>
                  <select class="form-control select_sn" name="choix_name">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <?php
                    // Lecture Base de donnée
                    $res = $connect->query("SELECT DISTINCT name from users");
                    // Lecture de chaque ligne dans la base de donnée
                    while ($row = mysqli_fetch_array($res)) {
                      $name = $row["name"];
                      echo  "<option value ="."$name".">"."$name"."</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
          <br/>
          <button type="submit" name="enregistrer_suppr" value ="Enregistrer_suppr" class="btn btn-primary bt_enregistrer ">Enregistrer</button>
        </form>

        <?php

        // on teste la déclaration de nos variables
        if (isset($_POST['enregistrer_suppr']) && $_POST['enregistrer_modif'] = "Enregistrer_suppr") {
          $name = trim($_POST['choix_name']);

          $res = $connect->query("SELECT EXISTS (SELECT name from users WHERE (name = '$name')) AS user_exists");
          $res->data_seek(0);
          $row = $res->fetch_assoc();

          if ($row['user_exists']) {
            $req_user = $connect->query("DELETE FROM users WHERE (name = '$name')");
            echo "<br/><h4 class=\"text-center vert\">L'utilisateur ".$name." a été supprimé !</h4><br/>";
            $name = "";
            $mdp = "";
          }else{
            echo "<br/><h4 class=\"text-center rouge\">L'utilisateur ".$name." n'existe pas dans la base de données</h4><br/>";
          }
        }
        ?>
      </div>
    </div>
  </div>
  <!-- /.row -->
</br>
</div>
<!-- /.container -->
<?php
// Fermeture de la connection mysql
mysqli_close($connect);
include('includes/footer_admin.php');
?>

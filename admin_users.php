<?php
// Inclusion du fichier d'ne tête
include('includes/header_admin.php');
?>

<!-- Page Content  -->
<div id="content">
  <h1 class="my-4 text-center h1_responsive">Administration des comptes utilisateurs :</h1>

  <!-- Création d'un utilisateur -->
  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3 portfolio-item">
      <div class="card h-100 table_shadow">
        <h3 class="my-4 title_table text-center h3_responsive">Création d'un utilisateur : </h3>
        <!-- Formulaire de création d'un utilisateur -->
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
                    $result = mysqli_query($connect,"SELECT DISTINCT profil from users");
                    // Lecture de chaque ligne dans la base de donnée
                    while ($row = mysqli_fetch_array($result)) {
                      $profil = $row["profil"];

                      if($profil == 1){
                        $profil = "utilisateur";
                      }else if($profil == 2){
                        $profil = "administrateur";
                      }
                      echo  "<option value ="."$profil".">"."$profil"."</option>";
                    }
                    // Libération des ressources associées au jeu de résultats
                    mysqli_free_result($result);
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
        // Test l'appui sur le bouton enregistrer
        if (isset($_POST['enregistrer']) && $_POST['enregistrer']="Enregistrer") {
          // Test si les champ nom et mot de passe et confirmation de mot de passe ne sont pas vides et que mdp == mdp_conf
          if(trim($_POST['name']) != "" && trim($_POST['mdp']) != "" && trim($_POST['mdp_conf']) != "" && trim($_POST['mdp']) == trim($_POST['mdp_conf'])){
            $name = trim($_POST['name']);
            $mdp = trim($_POST['mdp']);
            $profil = trim($_POST['choix_profil']);

            $result = mysqli_query($connect,"SELECT name from users WHERE (name = '$name' and profil = '$profil')");
            $row = mysqli_fetch_array($result);

            // Test que l'utilisateur n'existe pas en base de données
            if ($row['name'] == "") {
              // Libération des ressources associées au jeu de résultats
              mysqli_free_result($result);

              // Utilisation de l'algorithme bcrypt par défault
              $password_hash = password_hash(trim($mdp), PASSWORD_DEFAULT);

              // Requête d'insertion du nouvel utilisateur dans la base de données
              $stmt = mysqli_query($connect,"INSERT INTO users (name, password, profil) VALUES ('$name','$password_hash','$profil')");
              echo "<br/><h4 class=\"text-center vert\">L'utilisateur a été créé !</h4><br/>";
              // Réinitialisation des variables
              $name = "";
              $mdp = "";
              $profil = "";
            }else{
              echo "<br/><h4 class=\"text-center rouge\">L'utilisateur ".$name." existe déjà dans la base de données</h4><br/>";
            }
          }else{
            echo "<br/><h4 class=\"text-center rouge\">Un ou plusieurs champs sont erronées</h4><br/>";
          }
        }
        ?>
      </div>
    </div>
  </div>
  <!-- /.Création d'un utilisateur -->

  <!-- Modification d'un utilisateur -->
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
                    // Récupération des noms des utilisateurs dans la base
                    $result = mysqli_query($connect,"SELECT DISTINCT name from users");
                    // Lecture de chaque ligne dans la base de données
                    while ($row = mysqli_fetch_array($result)) {
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
        // Test l'appui sur le bouton enregistrer
        if (isset($_POST['enregistrer_modif']) && $_POST['enregistrer_modif']="Enregistrer_modif") {
          if(trim($_POST['mdp']) == trim($_POST['mdp_conf']) && $_POST['mdp'] != "" && $_POST['mdp_conf'] != ""){
            $name = trim($_POST['choix_name']);
            $mdp = trim($_POST['mdp']);

            // Utilisation de l'algorithme bcrypt par défault
            $password_hash = password_hash(trim($mdp), PASSWORD_DEFAULT);

            // Mise à jourdu champ mot de passe dans la base de données
            $req_user = mysqli_query($connect,"UPDATE users SET password ='$password_hash' WHERE (name = '$name')");
            echo "<br/><h4 class=\"text-center vert\">Le mot de passe de l'utilisateur ".$name." a été modifié !</h4><br/>";
            $name = "";
            $mdp = "";
          }else{
            echo "<br/><h4 class=\"text-center rouge\">Un ou plusieurs champs sont erronées</h4><br/>";
          }
        }
        ?>
      </div>
    </div>
  </div>
  <!-- /.Modification d'un utilisateur -->

  <!-- Suppression d'un utilisateur -->
  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3 portfolio-item">
      <div class="card h-100 table_shadow">
        <h3 class="my-4 title_table text-center h3_responsive">Suppresion d'un utilisateur : </h3>
        <form method="post" action="admin_users.php">
          <table class="table-multi table-bordered text-center table_perso">
            <tbody>
              <tr>
                <th scope="row">Nom :</th>
                <td class="td_unique">
                  <select class="form-control select_sn" name="choix_name">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <?php
                    // Récupération des noms des utilisateurs dans la base
                    $result = mysqli_query($connect,"SELECT DISTINCT name from users");
                    // Lecture de chaque ligne dans la base de donnée
                    while ($row = mysqli_fetch_array($result)) {
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
        // Test l'appui sur le bouton enregistrer
        if (isset($_POST['enregistrer_suppr']) && $_POST['enregistrer_modif'] = "Enregistrer_suppr") {
          $name = trim($_POST['choix_name']);

          $stmt = mysqli_query($connect,"DELETE FROM users WHERE (name = '$name')");
          echo "<br/><h4 class=\"text-center vert\">L'utilisateur ".$name." a été supprimé !</h4><br/>";
          $name = "";
          $mdp = "";
        }
        ?>
      </div>
    </div>
  </div>
  <!-- /.Suppression d'un utilisateur -->

</br>
</div>
<!-- /. Page Content  -->
<?php
// Fermeture de la connection mysql
mysqli_close($connect);
// Inclusion du fichier de bas de page
include('includes/footer_admin.php');
?>

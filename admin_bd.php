<?php
include('includes/header_admin.php');
//include('connexion_bd.php');
?>
<!-- Page Content  -->
<div id="content">
  <!--  <div id="page-content-wrapper"> -->
  <!--    <div class="container"> -->
  <div class="row justify-content-md-center">
    <div class="col-lg-12">
      <?php
      $choix_fonct = "visualiser";
      $choix_fonct = trim($_GET["choix_fonct"]);
      if($choix_fonct == "visualiser_bd"){
        ?>

        <h1 class="my-4 title_table h1_responsive text-center">Visualisation de la table de production :</h1>
        <div class="table_shadow">
          <table class="table-bordered text-center table-responsive table_perso">
            <tr>
              <th> Type </th>
              <th> SN </th>
              <th> Mesure </th>
              <th> Localisation </th>
              <th> Date enregistrée </th>
            </tr>
            <tbody>
              <?php
              // Lecture Base de donnée
              $res = $connect->query('SELECT type, serialNumber, measurement, location, DATE_FORMAT(dateTimeCreated, \'%d/%m/%Y à %H:%i:%s\' ) AS dateTimeCreatedFormat from tbl_message ORDER BY dateTimeCreated asc');

              // Lecture de chaque ligne dans la base de donnée
              while ($row = mysqli_fetch_array($res)) {
                $serialNumber = $row["serialNumber"];
                $type = $row["type"];
                $measurement = $row["measurement"];
                $dateTimeCreated = $row["dateTimeCreatedFormat"];
                $location = $row["location"];
                $location = trim($location);

                echo"
                <tr>
                <td>
                <input class=\"no-border input_visu\" readonly=\"true\" type=\"text\" name=\"type\" value=".$type.">
                </td>
                <td>
                <input class=\"no-border input_visu\" readonly=\"true\" type=\"text\" name=\"sn\" value=".$serialNumber.">
                </td>
                <td>
                <input class=\"no-border input_visu\" readonly=\"true\" type=\"text\" name=\"mesure\" value=".$measurement.">
                </td>
                <td>
                <input class=\"no-border input_visu\" readonly=\"true\" type=\"text\" name=\"coordonnees\" value=".$location.">
                </td>
                <td>
                <input class=\"no-border input_visu_large\" readonly=\"true\" type=\"text\" name=\"coordonnees\" value='$dateTimeCreated'>
                </td>
                </tr>
                ";
              }
              ?>
            </tbody>
          </table>
        </div>
        <br/>
        <br/>
      </div>
    </div>
  </div>
</div>
<?php
}else if($choix_fonct == "modifier"){
  // Cas 2 : Modification de la base de données
  ?>
  <!-- Ajout de la localisation d'une sonde -->
  <h1 class="my-4 text-center h1_responsive">Ajout d'une localisation pour une sonde :</h1>
  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3">
      <div class="card h-100 table_shadow">
        <h3 class="my-4 title_table text-center h3_responsive">Ajout localisation : </h3>
        <form method="post" action="admin_bd.php?choix_fonct=modifier">
          <table class="table-multi table-bordered text-center table-responsive table_perso">
            <tbody>
              <tr>
                <th scope="row">Numéro de série de la sonde :</th>
                <td>
                  <select class="form-control select_sn" name="choix_serialNumber">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <?php
                    // Lecture Base de donnée
                    $res = $connect->query("SELECT DISTINCT serialNumber from parc");
                    // Lecture de chaque ligne dans la base de donnée
                    while ($row = mysqli_fetch_array($res)) {
                      $sn = $row["serialNumber"];
                      echo  "<option value ="."$sn".">"."$sn"."</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th scope="row">Localisation de la sonde :</th>
                <td>
                  <input class="no-border" type="text" name="location">
                </td>
              </tr>
            </tbody>
          </table>
          <br/>
          <button type="submit" name="enregistrer_ajout" value = "Enregistrer_ajout" class="btn btn-primary bt_enregistrer ">Enregistrer</button>
        </form>

        <?php
        // on teste la déclaration de nos variables
        if (isset($_POST['enregistrer_ajout']) && $_POST['enregistrer_ajout']="Enregistrer_ajout") {
          if(trim($_POST['location']) != ""){
            $sn = trim($_POST['choix_serialNumber']);
            $location = trim($_POST['location']);

            $res = $connect->query("UPDATE parc SET location = '$location' WHERE serialNumber ='$sn'");
            $res = $connect->query("UPDATE tbl_message SET location = '$location' WHERE serialNumber ='$sn'");
            echo "<br/><h4 class=\"text-center vert \">Ajout de la localisation effectuée</h4><br/>";
          }else{
            echo "<br/><h4 class=\"text-center rouge \">Veuillez entrer saisir une localisation pour cette sonde </h4><br/>";
          }
        }
        ?>
        <!-- /.col-lg-6 portfolio-item -->
      </div>
      <!-- /.row -->
    </div>
  </div>
  <br/>

  <!-- SUPPRESSION D'UNE SONDE -->
  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3">
      <div class="card h-100 table_shadow">
        <h3 class="my-4 title_table text-center h3_responsive">Suppresion d'une sonde : </h3>
        <form method="post" action="admin_bd.php?choix_fonct=modifier">
          <table class="table-multi table-bordered text-center table-responsive table_perso">
            <tbody>
              <tr>
                <th scope="row">Numéro de série de la sonde :</th>
                <td>
                  <select class="form-control select_sn" name="choix_serialNumber">
                    <option value ="..." selected="selected" readonly="true">...</option>
                    <?php
                    // Lecture Base de donnée
                    $res = $connect->query("SELECT DISTINCT serialNumber from parc");
                    // Lecture de chaque ligne dans la base de données
                    while ($row = mysqli_fetch_array($res)) {
                      $sn = $row["serialNumber"];
                      echo  "<option value ="."$sn".">"."$sn"."</option>";
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
        // On test la déclaration de nos variables
        if (isset($_POST['enregistrer_suppr']) && $_POST['enregistrer_modif']="Enregistrer_suppr") {
          $sn = trim($_POST['choix_serialNumber']);

          $res = $connect->query("SELECT EXISTS (SELECT serialNumber from parc WHERE (serialNumber = '$sn')) AS sonde_exists");
          $res->data_seek(0);
          $row = $res->fetch_assoc();

          if ($row['sonde_exists'] == true) {
            // Suppression dans la table de production : tbl_message
            $req_sonde = $connect->query("DELETE FROM tbl_message WHERE (serialNumber = '$sn')");
            // Suppresio dans la table de gestion de parc : parc
            $req_sonde = $connect->query("DELETE FROM parc WHERE (serialNumber = '$sn')");
            echo "<br/><h4 class=\"text-center vert\">La sonde ".$sn." a été supprimé !</h4><br/>";
            $sn = "";
          }else{
            echo "<br/><h4 class=\"text-center rouge\">La sonde ".$sn." n'existe pas dans la base de données</h4><br/>";
          }
        }
        ?>
        <!-- /.col-lg-6 portfolio-item -->
      </div>
      <!-- /.row -->
    </div>
  </div>
  <?php
}else if($choix_fonct == "visualiser_parc"){
  ?>
  <h1 class="my-4 title_table h1_responsive text-center">Visualisation de la table de gestion de parc :</h1>
  <div class="table_shadow">
    <table class="table-bordered text-center table-responsive table_perso">
      <tr>
        <th> SN </th>
        <th> Type </th>
        <th> Localisation </th>
        <th> Statut </th>
        <th> Date mise en production </th>
      </tr>
      <tbody>
        <?php
        // Lecture dans la table parc
        $res = $connect->query('SELECT serialNumber, type, location, status, DATE_FORMAT(dateTimeProduction, \'%d/%m/%Y à %H:%i:%s\' ) AS dateTimeProductionFormat from parc ORDER BY serialNumber asc');

        // Lecture de chaque ligne dans la base de donnée
        while ($row = mysqli_fetch_array($res)) {
          $serialNumber = $row["serialNumber"];
          $type = $row["type"];
          $status= $row["status"];
          $dateTimeProduction = $row["dateTimeProductionFormat"];
          $location = $row["location"];
          $location = trim($location);

          if($status == 0){
            $status = "HS";
          }else if($status == 1){
            $status = "OK";
          }

          echo"
          <tr>
          <td>
          <input class=\"no-border input_visu\" readonly=\"true\" type=\"text\" name=\"type\" value=".$serialNumber.">
          </td>
          <td>
          <input class=\"no-border input_visu\" readonly=\"true\" type=\"text\" name=\"sn\" value=".$type.">
          </td>
          <td>
          <input class=\"no-border input_visu\" readonly=\"true\" type=\"text\" name=\"mesure\" value=".$location.">
          </td>
          <td>
          <input class=\"no-border input_visu\" readonly=\"true\" type=\"text\" name=\"coordonnees\" value=".$status.">
          </td>
          <td>
          <input class=\"no-border input_visu_large\" readonly=\"true\" type=\"text\" name=\"coordonnees\" value='$dateTimeProduction'>
          </td>
          </tr>
          ";
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
}
?>
<!-- </div> -->
<!-- </div> -->
</div>

<?php
// Fermeture de la connection mysql
mysqli_close($connect);
include('includes/footer_admin.php');
?>

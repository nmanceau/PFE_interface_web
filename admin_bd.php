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
      if($choix_fonct == "visualiser"){
        ?>

        <h1 class="my-4 title_table h1_responsive text-center">Visualiser la base de données :</h1>
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
              $res = $connect->query('SELECT type, serialNumber, measurement, location, DATE_FORMAT(dateTimeCreated, \'%d/%m/%Y à %H:%i:%s\' ) AS dateTimeCreatedFormat from tbl_message ORDER BY serialNumber asc');

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
}else{
  // Cas 2 : Modification de la base de données
  ?>
  <h1 class="my-4 text-center h1_responsive">Modification de la base de données :</h1>
  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3">
      <div class="card h-100 table_shadow">
        <h3 class="my-4 title_table text-center h3_responsive">Suppresion d'une sonde : </h3>
        <form method="post" action="admin_bd.php">
          <table class="table-multi table-bordered text-center table-responsive table_perso">
            <tbody>
              <tr>
                <th scope="row">Numéro de série de la sonde :</th>
                <td>
                  <input class="no-border" type="text" name="sn">
                </td>
              </tr>
            </tbody>
          </table>
          <br/>
          <button type="submit" name="enregistrer_suppr" value ="Enregistrer_suppr" class="btn btn-primary bt_enregistrer ">Enregistrer</button>
        </form>

        <?php
        // on teste la déclaration de nos variables
        if (isset($_POST['enregistrer_suppr']) && $_POST['enregistrer_modif']="Enregistrer_suppr") {
          if(trim($_POST['sn']) != ""){
            $sn = trim($_POST['sn']);

            $res = $connect->query("SELECT EXISTS (SELECT serialNumber from tbl_message WHERE (serialNumber = '$sn')) AS sonde_exists");
            $res->data_seek(0);
            $row = $res->fetch_assoc();

            if ($row['sonde_exists'] == true) {
              $req_sonde = $connect->query("DELETE FROM tbl_message WHERE (serialNumber = '$sn')");
              echo "<br/><h4 class=\"text-center\">La sonde ".$sn." a été supprimé !</h4><br/>";
              $sn = "";
            }else{
              echo "<br/><h4 class=\"text-center\">La sonde ".$sn." n'existe pas dans la base de données</h4><br/>";
            }
          }else{
            echo "<br/><h4 class=\"text-center\">Veuillez entrer le numéro de série de la sonde à supprimer</h4><br/>";
          }
        }
        ?>
        <!-- /.col-lg-6 portfolio-item -->
      </div>
      <!-- /.row -->
    </div>
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

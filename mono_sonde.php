<?php
// Démarrage de la session
session_start();

if($_SESSION["name"] != ""){
// Inclusion du fichier d'en tête
include('includes/header.php');
?>
<!-- Page Content  -->
<div id="content">
  <?php
  // Récupération du numéro de série de la sonde sléectionnée
  $serialNumber_choix = $_GET["choix_serialNumber"];
  // Récupération des informations de la sonde
  $result = mysqli_query($connect,'SELECT type, serialNumber, measurement, location, DATE_FORMAT(dateTimeCreated, \'%d/%m/%Y à %H:%i:%s\') AS dateTimeCreatedFormat from tbl_message WHERE (serialNumber = '.$serialNumber_choix.') ORDER BY dateTimeCreated asc');

  // Lecture de chaque ligne dans la base de données
  while ($row = mysqli_fetch_array($result)) {
    $serialNumber = $row["serialNumber"];
    $type = $row["type"];
    $measurement = $row["measurement"];
    $dateTimeCreated = $row["dateTimeCreatedFormat"];
    $location = $row["location"];
    $location = trim($location);
  }

  // Affichage du tableau qui contient les informations d'une sonde
  echo"
  <div class=\"row justify-content-md-center\">
  <div class=\"col-lg-6 col-lg-offset-3 portfolio-item\">
  <h1 class=\"my-4 title_table\">Mono sonde :</h1>
  <div class=\"card h-60 table_shadow\">
  <table class=\"table-bordered table-responsive text-center table_perso\">
  <tbody>
  <tr>
  <th scope=\"row\">Type :</th>
  <td>
  <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"type\" value=".$type.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Numéro de série : </th>
  <td>
  <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"sn\" value=".$serialNumber.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Mesure en cps : </th>
  <td>
  <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"mesure\" value=".$measurement.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Localisation : </th>
  <td>
  <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"localisation\" value=".$location.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Date crée : </th>
  <td>
  <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"date\" value='$dateTimeCreated'>
  </td>
  </tr>
  </tbody>
  </table>
  </div>
  </div>
  </div>";
  ?>

  <!-- GRAPHIQUE -->
  </br>
  <div class="row justify-content-md-center">
    <div class="col-lg-6 col-lg-offset-3 portfolio-item">
      <div id="chart-container" class="card h-60 table_shadow">
        <canvas id="graphCanvas" class="text-center"></canvas>
      </div>
    </div>
  </div>
</div>
<!-- /.Page Content  -->

<!-- Script pour afficher le graphique  -->
<script>
$(document).ready(function () {
  showGraph();
});

var choix_serialNumber = "<?php echo $serialNumber_choix ?>";

function showGraph()
{
  {
    $.post("data.php","choix="+ choix_serialNumber,
    function (data)
    {
      console.log(data);
      var date = [];
      var measure = [];

      for (var i in data) {
        date.push(data[i].dateTimeCreated);
        measure.push(data[i].measurement);
      }

      var chartdata = {
        labels: date,
        datasets: [
          {
            label: 'Mesure sonde',
            backgroundColor: '#ff8c00',
            borderColor: '#ff8c00',
            hoverBackgroundColor: '#CCCCCC',
            hoverBorderColor: '#666666',
            data: measure
          }
        ]
      };

      var graphTarget = $("#graphCanvas");

      var barGraph = new Chart(graphTarget, {
        type: 'line',
        data: chartdata,
        responsive :true
      });
    });
  }
}
</script>

<?php
// Fermeture de la connection mysql
mysqli_close($connect);
// Inclusion du fichier de bas de page
include('includes/footer.php');
}
?>

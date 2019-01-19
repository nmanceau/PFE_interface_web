<?php
include('includes/header.php');
?>
<!-- Page Content  -->
<div id="content">
  <?php
  $adresse = $_SERVER['PHP_SELF'];
  $i = 0;
  foreach($_GET as $cle => $valeur){
    $adresse .= ($i == 0 ? '?' : '&').$cle.($valeur ? '='.$valeur : '');
    $i++;
  }

  if($adresse != "/git_PFE/mono_sonde.php"){
    $serialNumber_choix = $_GET["choix_serialNumber"];
    // Lecture Base de donnée
    $res = $connect->query('SELECT type, serialNumber, measurement, location, DATE_FORMAT(dateTimeCreated, \'%d/%m/%Y à %H:%i:%s\') AS dateTimeCreatedFormat from tbl_message WHERE (serialNumber = '.$serialNumber_choix.') ORDER BY dateTimeCreated asc');

    // Lecture de chaque ligne dans la base de donnée
    while ($row = mysqli_fetch_array($res)) {
      $serialNumber = $row["serialNumber"];
      $type = $row["type"];
      $measurement = $row["measurement"];
      $dateTimeCreated = $row["dateTimeCreatedFormat"];
      $location = $row["location"];
      $location = trim($location);
    }

  }else{
    $serialNumber ="";
    $type = "";
    $measurement = "";
    $dateTimeCreated = "";
    $location = "";
  }
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
  <th scope=\"row\">Coordonées : </th>
  <td>
  <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"coordonnees\" value=".$location.">
  </td>
  </tr>
  <tr>
  <th scope=\"row\">Date crée : </th>
  <td>
  <input class=\"no-border\" readonly=\"true\" type=\"text\" name=\"coordonnees\" value='$dateTimeCreated'>
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
include('includes/footer.php');

?>

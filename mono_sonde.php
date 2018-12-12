<?php
include('header.php');

// Variable de connexion à la base de donnée
$host_name = "localhost";
$database = "mydb";
$user_name = "user";
$password = "user";

// Connection à la base de donnée
$connect = mysqli_connect($host_name, $user_name, $password, $database);
?>

<body class="bg-blue">
  <div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="nav-item active sidebar-brand">
          <li class="nav-item dropdown toggle">
            <a class="nav-link dropdown-toggle bold" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Mono Sonde :
              <span class="sr-only">(current)</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <form method="post" action="mono_sonde.php">
                <div class="form-group">
                  <label for="choix_serialNumber">Choix de la sonde : </label>
                  <select class="form-control" value="choix_serialNumber">
                    <?php
                    // Lecture Base de donnée
                    $res = $connect->query("SELECT DISTINCT serialNumber from tbl_message");
                    $res->data_seek(0);
                    // Lecture de chaque ligne dans la base de donnée
                    while ($row = $res->fetch_assoc()) {
                      $serialNumber = $row["serialNumber"];
                      echo  "<option value ="."$serialNumber".">"."$serialNumber"."</option>";
                    }
                    ?>
                  </select>
                </div>
              </form>
            </div>
          </li>
        </li>
        <li class="nav-item sidebar-brand">
          <a class="nav-link bold" href="multi_sondes.php">Multi Sondes</a>
        </li>
      </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <?php
    /*
    if(isset($_POST['test'])){
    $serialNumber_choix = $_POST["choix_serialNumber"];
    echo "ok";
  }
  */
  $serialNumber_choix = 1;

  // Lecture Base de donnée
  $res = $connect->query("SELECT type, serialNumber, measurement, dateTimeCreated, location from tbl_message WHERE (serialNumber = '$serialNumber_choix') ORDER BY dateTimeCreated desc");
  $res->data_seek(0);
  $row = $res->fetch_assoc();

  // Lecture de chaque ligne dans la base de donnée
  while ($row = $res->fetch_assoc()) {
    $serialNumber = $row["serialNumber"];
    $type = $row["type"];
    $measurement = $row["measurement"];
    $dateTimeCreated = $row["dateTimeCreated"];
    $location = $row["location"];
  }

  // Fermeture de la connection mysql
  mysqli_close($connect);
  ?>

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="my-4 title_table">Sonde CSP</h1>

      <table class="table" width="50%" diplay="grid">
        <tbody>
          <tr>
            <th scope="row">Type :</th>
            <td>
              <input readonly="true" type="text" name="type" value="<?php echo $type ; ?>">
            </td>
          </tr>
          <tr>
            <th scope="row">Numéro de série : </th>
            <td>
              <input readonly="true" type="text" name="sn" value="<?php echo $serialNumber ; ?>">
            </td>
          </tr>
          <tr>
            <th scope="row">Mesure en cps : </th>
            <td>
              <input readonly="true" type="text" name="mesure" value="<?php echo $measurement ; ?>">
            </td>
          </tr>
          <tr>
            <th scope="row">Coordonées : </th>
            <td>
              <input readonly="true" type="text" name="coordonnees" value="<?php echo $location ; ?>">
            </td>
          </tr>
          <tr>
            <th scope="row">Date crée : </th>
            <td>
              <input readonly="true" type="text" name="coordonnees" value="<?php echo $dateTimeCreated ; ?>">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->
</body>

<?php
include('footer.php');
?>

<?php
// Variable de connexion à la base de donnée
$host_name = "localhost";
$database = "mydb";
$user_name = "user";
$mdp = "user";

// Connection à la base de donnée
$connect = mysqli_connect($host_name, $user_name, $mdp, $database);
?>

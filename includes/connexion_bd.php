<?php
// Variable de connexion à la base de données
$host_name = "localhost";
$database = "mydb";
$user_name = "user";
$mdp = "user";

// Connexion à la base de données
$connect = mysqli_connect($host_name, $user_name, $mdp, $database);
?>

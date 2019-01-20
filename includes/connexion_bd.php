<?php
// Variable de connexion à la base de données
$host_name = "localhost";
$database = "mydb";
$user_name = "user";
$mdp = "user";

// Connexion à la base de données
$connect = mysqli_connect($host_name, $user_name, $mdp, $database);

/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Echec de la connexion : %s\n", mysqli_connect_error());
    exit();
}
?>

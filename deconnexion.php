<?php
// Démarrage de la session
session_start();

$_SESSION['surname'] = "";

// Destruction de la session
session_destroy();
header('Location: login.php');
?>

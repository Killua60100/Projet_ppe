<?php
session_start();
session_destroy();
header("Location: connexion.php"); // Redirige vers connection.php après déconnexion
exit();
?>

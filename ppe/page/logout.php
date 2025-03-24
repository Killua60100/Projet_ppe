<?php
session_start();
session_destroy();
header("Location: connection.php"); // Redirige vers connection.php après déconnexion
exit();
?>

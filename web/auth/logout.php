<?php
session_start(); // Inicia la sesión

// Destruye todos los datos de la sesión
$_SESSION = [];
session_unset();
session_destroy();

// Redirige al login o a la página principal
header("Location: ../login.php");
exit;

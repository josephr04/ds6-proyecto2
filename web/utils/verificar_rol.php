<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

function verificarRol($rolPermitido) {
    if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != $rolPermitido) {
        header("Location: ../login.php?error=Acceso denegado.");
        exit();
    }
}
<?php
$conexion = new mysqli("localhost", "root", "", "ds6p2");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
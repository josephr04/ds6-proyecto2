<?php
header('Content-Type: application/json');
include '../utils/conexion.php';

$productos = [];

$sql = "SELECT id, nombre, precio, img_url AS imagen FROM productos";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
}

$conexion->close();
echo json_encode($productos);
?>
<?php
include 'utils/conexion.php';

$productos = [];

$sql = "SELECT id, nombre, precio, img_url AS imagen FROM productos ORDER BY RAND() LIMIT 8";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
	while ($fila = $resultado->fetch_assoc()) {
		$productos[] = $fila;
	}
} else {
	echo "No se encontraron productos.";
}

$conexion->close();
?>
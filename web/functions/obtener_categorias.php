<?php
include 'utils/conexion.php';

// Obtener categorías
$categorias = [];
$sql_categorias = "SELECT id, nombre FROM categorias"; // Ajusta según tu estructura de tabla
$resultado_categorias = $conexion->query($sql_categorias);

if ($resultado_categorias && $resultado_categorias->num_rows > 0) {
	while ($fila = $resultado_categorias->fetch_assoc()) {
		$categorias[] = $fila;
	}
}

$conexion->close();
?>
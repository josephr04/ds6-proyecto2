<?php
include 'utils/conexion.php';

if (!isset($_SESSION['rol_id'])) {
	header('Location: ../login.php');
	exit();
}

// Obtener el id de la categoría desde URL y validarlo
$categoria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$productos = [];
$categoria_nombre = '';
$categoria_img = '';

if ($categoria_id > 0) {
	// Obtener nombre e imagen de la categoría
	$sql_categoria = "SELECT nombre, img_url FROM categorias WHERE id = $categoria_id";
	$resultado_categoria = $conexion->query($sql_categoria);
	if ($resultado_categoria && $resultado_categoria->num_rows > 0) {
		$fila_categoria = $resultado_categoria->fetch_assoc();
		$categoria_nombre = $fila_categoria['nombre'];
		$categoria_img = $fila_categoria['img_url'] ?? '';

		// Obtener productos de la categoría
		$sql_productos = "SELECT id, nombre, precio, img_url AS imagen FROM productos WHERE categoria_id = $categoria_id";
		$resultado_productos = $conexion->query($sql_productos);

		if ($resultado_productos && $resultado_productos->num_rows > 0) {
			while ($fila = $resultado_productos->fetch_assoc()) {
				$productos[] = $fila;
			}
		}
	} else {
		$categoria_nombre = 'Categoría no encontrada';
	}
} else {
	$categoria_nombre = 'Categoría inválida o no especificada';
}

$conexion->close();

// Definir estilo de fondo para el header
$header_bg = '';
if (!empty($categoria_img)) {
	$header_bg = "style=\"background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('./../imagenes/categorias/" . htmlspecialchars($categoria_img) . "'); background-size: cover; background-position: center;\"";
} else {
	$header_bg = "style=\"background-color: #343a40;\"";
}
?>
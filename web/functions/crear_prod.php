<?php
include 'utils/conexion.php';

$categorias = [];
$mensaje = "";

// Obtener todas las categorías
$result = $conexion->query("SELECT id, nombre FROM categorias");
while ($cat = $result->fetch_assoc()) {
	$categorias[] = $cat;
}

// Guardar nuevo producto
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$nombre = $_POST["nombre"];
	$descripcion = $_POST["descripcion"];
	$precio = $_POST["precio"];
	$categoria_id = $_POST["categoria"];
	$imagen_nombre = null;

	// Manejar imagen si se subió
	if (!empty($_FILES["imagen"]["name"])) {
		$imagen_nombre = basename($_FILES["imagen"]["name"]);
		$ruta_destino = "assets/productos/" . $imagen_nombre;
		move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_destino);
	}

	$sql = "INSERT INTO productos (nombre, descripcion, precio, img_url, categoria_id) VALUES (?, ?, ?, ?, ?)";
	$stmt = $conexion->prepare($sql);
	$stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $imagen_nombre, $categoria_id);
	$stmt->execute(); 
	$stmt->close();

	$mensaje = "Producto creado exitosamente.";
	$return_url = $_POST['return_url'] ?? 'dashboard.php';
	header("Location: " . $return_url);
	exit();
}

$conexion->close();
?>
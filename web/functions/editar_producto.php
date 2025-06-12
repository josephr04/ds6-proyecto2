<?php
include 'utils/conexion.php';

$id = $_GET['id'] ?? null;
$producto = null;
$categorias = [];

// Obtener todas las categorías
$result_cat = $conexion->query("SELECT id, nombre FROM categorias");
while ($cat = $result_cat->fetch_assoc()) {
	$categorias[] = $cat;
}

// Obtener producto por ID
if ($id) {
	$stmt = $conexion->prepare("SELECT id, nombre, descripcion, precio, img_url AS imagen, categoria_id FROM productos WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$resultado = $stmt->get_result();

	if ($resultado->num_rows === 1) {
		$producto = $resultado->fetch_assoc();
	}
	$stmt->close();
}

// Eliminar solo la imagen
if (isset($_GET['eliminar_imagen']) && $producto) {
	$ruta_imagen = "assets/productos/" . $producto['imagen'];
	if (file_exists($ruta_imagen)) {
		unlink($ruta_imagen);
	}

	$sql = "UPDATE productos SET img_url = NULL WHERE id = ?";
	$stmt = $conexion->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();

	header("Location: producto.php?id=" . $id);
	exit();
}

// Eliminar producto completo
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['eliminar_producto']) && $producto) {
	if (!empty($producto['imagen'])) {
		$ruta_imagen = "assets/productos/" . $producto['imagen'];
		if (file_exists($ruta_imagen)) {
			unlink($ruta_imagen);
		}
	}

	$stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();

	header("Location: dashboard.php");
	exit();
}

// Guardar cambios del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && $producto && !isset($_POST['eliminar_producto'])) {
	$nuevo_nombre = $_POST["nombre"];
	$nueva_descripcion = $_POST["descripcion"];
	$nuevo_precio = $_POST["precio"];
	$nueva_categoria_id = $_POST["categoria"];

	if (!empty($_FILES["imagen"]["name"])) {
		$nombre_archivo = basename($_FILES["imagen"]["name"]);
		$ruta_destino = "assets/productos/" . $nombre_archivo;
		move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_destino);

		$sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, img_url=?, categoria_id=? WHERE id=?";
		$stmt = $conexion->prepare($sql);
		$stmt->bind_param("ssdssi", $nuevo_nombre, $nueva_descripcion, $nuevo_precio, $nombre_archivo, $nueva_categoria_id, $id);
	} else {
		$sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, categoria_id=? WHERE id=?";
		$stmt = $conexion->prepare($sql);
		$stmt->bind_param("ssdii", $nuevo_nombre, $nueva_descripcion, $nuevo_precio, $nueva_categoria_id, $id);
	}

	$stmt->execute();
	$stmt->close();

	$return_url = $_POST['return_url'] ?? 'dashboard.php';
	header("Location: " . $return_url);
	exit();
}

$conexion->close();
?>
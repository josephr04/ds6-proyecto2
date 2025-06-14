<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (!isset($_SESSION['rol_id'])) {
	header('Location: ../login.php');
	exit();
}

if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] !== 1) {
	$_SESSION['error_message'] = "Acceso denegado. Solo administradores pueden realizar dicha función.";
	header('Location: ../dashboard.php');
	exit();
}

include 'utils/conexion.php';

$categorias = [];

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

	try {
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

		$_SESSION['success_message'] = "Producto creado exitosamente.";
	} catch (Exception $e) {
		$_SESSION['error_message'] = "Error al crear el producto: " . $e->getMessage();
	}

	$return_url = $_POST['return_url'] ?? 'dashboard.php';
	header("Location: " . $return_url);
	exit();
}

$conexion->close();
?>

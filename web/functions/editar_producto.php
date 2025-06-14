<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (!isset($_SESSION['rol_id'])) {
	header('Location: ../login.php');
	exit();
}

$rol_id = $_SESSION['rol_id'] ?? 2;

include 'utils/conexion.php';

$id = $_GET['id'] ?? null;
$producto = null;
$categorias = [];

// Obtener categorías
$result_cat = $conexion->query("SELECT id, nombre FROM categorias");
while ($cat = $result_cat->fetch_assoc()) {
	$categorias[] = $cat;
}

// Obtener producto
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

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if ($rol_id !== 1) {
		$_SESSION['error_message'] = "Acceso denegado. Solo administradores pueden realizar dicha función.";
		header('Location: ../dashboard.php');
		exit();
	}

	$return_url = $_POST['return_url'] ?? 'dashboard.php';

	// Eliminar producto completo
	if (isset($_POST['eliminar_producto']) && $producto) {
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

		$_SESSION['success_message'] = "Producto eliminado exitosamente.";
		header("Location: " . $return_url);
		exit();
	}

	// Editar producto
	if ($producto && !isset($_POST['eliminar_producto'])) {
		$nuevo_nombre = $_POST["nombre"];
		$nueva_descripcion = $_POST["descripcion"];
		$nuevo_precio = $_POST["precio"];
		$nueva_categoria_id = $_POST["categoria"];

		try {
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

			$_SESSION['success_message'] = "Producto actualizado exitosamente.";
		} catch (Exception $e) {
			$_SESSION['error_message'] = "Error al actualizar producto: " . $e->getMessage();
		}

		header("Location: " . $return_url);
		exit();
	}
}

// Eliminar solo la imagen
if (isset($_GET['eliminar_imagen']) && $producto) {
	if ($rol_id !== 1) {
		$_SESSION['error_message'] = "Acceso denegado. Solo administradores pueden realizar dicha función.";
		header('Location: ../dashboard.php');
		exit();
	}

	$ruta_imagen = "assets/productos/" . $producto['imagen'];
	if (file_exists($ruta_imagen)) {
		unlink($ruta_imagen);
	}

	$sql = "UPDATE productos SET img_url = NULL WHERE id = ?";
	$stmt = $conexion->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();

	$_SESSION['success_message'] = "Imagen eliminada correctamente.";
	$return_url = $_GET['return_url'] ?? "producto.php?id=" . $id;
	header("Location: " . $return_url);
	exit();
}

$conexion->close();
?>

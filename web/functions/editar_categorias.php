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

$mensaje = "";
$upload_dir = "./../imagenes/categorias/";
$categorias2 = [];

// Agregar nueva categoría
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nueva_categoria'])) {
	$nuevo_nombre = trim($_POST['nueva_categoria']);
	$img_nombre = null;

	if (!empty($nuevo_nombre)) {
		if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === UPLOAD_ERR_OK) {
			$tmp_name = $_FILES['nueva_imagen']['tmp_name'];
			$img_nombre = basename($_FILES['nueva_imagen']['name']);
			move_uploaded_file($tmp_name, $upload_dir . $img_nombre);
		}

		$stmt = $conexion->prepare("INSERT INTO categorias (nombre, img_url) VALUES (?, ?)");
		$stmt->bind_param("ss", $nuevo_nombre, $img_nombre);
		$stmt->execute();
		$stmt->close();

		header("Location: gestionar_categorias.php?msg=" . urlencode("Nueva categoría agregada correctamente."));
		exit();
	} else {
		header("Location: gestionar_categorias.php?msg=" . urlencode("El nombre de la nueva categoría no puede estar vacío."));
		exit();
	}
}

// Guardado masivo
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['guardar_todo'])) {
	foreach ($_POST['nombre'] as $id => $nuevo_nombre) {
		$stmt = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
		$stmt->bind_param("si", $nuevo_nombre, $id);
		$stmt->execute();
		$stmt->close();
	}

	foreach ($_FILES['imagen_actualizada']['tmp_name'] as $id => $tmpPath) {
		if ($_FILES['imagen_actualizada']['error'][$id] === UPLOAD_ERR_OK && is_uploaded_file($tmpPath)) {
			$img_nombre = basename($_FILES['imagen_actualizada']['name'][$id]);
			move_uploaded_file($tmpPath, $upload_dir . $img_nombre);

			$stmt = $conexion->prepare("UPDATE categorias SET img_url = ? WHERE id = ?");
			$stmt->bind_param("si", $img_nombre, $id);
			$stmt->execute();
			$stmt->close();
		}
	}

	header("Location: gestionar_categorias.php?msg=" . urlencode("Categorías actualizadas correctamente."));
	exit();
}

// Eliminar categoría
if (isset($_GET['eliminar'])) {
	$id = $_GET['eliminar'];
	$stmt = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();

	header("Location: gestionar_categorias.php?msg=" . urlencode("Categoría eliminada correctamente."));
	exit();
}

// Obtener categorías
$resultado = $conexion->query("SELECT id, img_url, nombre FROM categorias");
while ($cat = $resultado->fetch_assoc()) {
	$categorias2[] = $cat;
}
$conexion->close();

<?php
header('Content-Type: application/json');
include '../utils/conexion.php';

$productos = [];

// Validar ID
$categoria_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($categoria_id > 0) {
    $sql = "SELECT id, nombre, precio, img_url AS imagen FROM productos WHERE categoria_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }

    $stmt->close();
}

$conexion->close();
echo json_encode($productos);
?>

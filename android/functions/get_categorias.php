<?php
header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "", "ds6p2");
if ($conexion->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Error de conexión: " . $conexion->connect_error]);
  exit();
}

$sql = "SELECT id, nombre FROM categorias";
$resultado = $conexion->query($sql);

$categorias = [];
if ($resultado) {
  while ($fila = $resultado->fetch_assoc()) {
    $categorias[] = $fila;
  }
}

echo json_encode($categorias);

$conexion->close();
?>
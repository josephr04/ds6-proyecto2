<?php
include 'utils/conexion.php';

// Configuración de paginación
$productos_por_pagina = 12;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $productos_por_pagina;

// Obtener el total de productos
$total_resultado = $conexion->query("SELECT COUNT(*) as total FROM productos");
$total_fila = $total_resultado->fetch_assoc();
$total_productos = (int)$total_fila['total'];

// Calcular el total de páginas
$total_paginas = ceil($total_productos / $productos_por_pagina);

// Obtener los productos para la página actual
$productos = [];
$sql = "SELECT id, nombre, precio, img_url AS imagen FROM productos LIMIT $offset, $productos_por_pagina";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
  while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
  }
}

$conexion->close();
?>
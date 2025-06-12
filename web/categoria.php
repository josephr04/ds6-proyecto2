<?php
include 'utils/conexion.php';

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
    $header_bg = "style=\"background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/categorias/" . htmlspecialchars($categoria_img) . "'); background-size: cover; background-position: center;\"";
} else {
    $header_bg = "style=\"background-color: #343a40;\"";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Productos - <?php echo htmlspecialchars($categoria_nombre); ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css">
    <link href="styles.css" rel="stylesheet" />
</head>
<body>

<!-- Navigation -->
<?php include 'components/header.php'; ?>

<!-- Header con imagen de fondo o color -->
<header class="py-5 text-white" <?php echo $header_bg; ?>>
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center">
            <h1 class="display-4 fw-bolder"><?php echo htmlspecialchars($categoria_nombre); ?></h1>
            <?php if ($categoria_id > 0 && $categoria_nombre !== 'Categoría no encontrada'): ?>
                <p class="lead fw-normal text-white-50 mb-0">
                    <?php echo count($productos); ?> Producto<?php echo count($productos) !== 1 ? 's' : ''; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Section de productos -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <?php if ($categoria_id <= 0 || $categoria_nombre === 'Categoría inválida o no especificada'): ?>
            <div class="alert alert-warning text-center">No se especificó una categoría válida.</div>
        <?php elseif (empty($productos)): ?>
            <div class="alert alert-info text-center my-5 py-5">No se encontraron productos en esta categoría.</div>
        <?php else: ?>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($productos as $producto): ?>
                    <?php
                    $nombre = $producto['nombre'];
                    $precio = $producto['precio'];
                    $id = $producto['id'];

                    if (!empty($producto['imagen'])) {
                        $imagen = '../web/assets/productos/' . $producto['imagen'];
                    } else {
                        $imagen = "https://dummyimage.com/456x399/dee2e6/000000.png?text=" . urlencode($nombre);
                    }

                    include 'components/card.php';
                    ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Footer -->
<?php include 'components/footer.php'; ?>

<script src="js/scripts.js"></script>
</body>
</html>

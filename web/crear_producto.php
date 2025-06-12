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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'components/header.php'; ?>

    <div class="container py-5">
        <h2 class="mb-4">Agregar Nuevo Producto</h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
            </div>

            <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'dashboard.php'); ?>">
            <button type="submit" class="btn btn-primary">Crear Producto</button>
            <a onclick="history.back();" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <?php include 'components/footer.php'; ?>
</body>
</html>

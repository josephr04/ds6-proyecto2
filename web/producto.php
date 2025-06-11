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

    header("Location: dashboard.php");
    exit();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
  
    <!-- Navigation-->
    <?php include 'components/header.php'; ?>

    <div class="container py-5">
        <?php if ($producto): ?>
            <h2 class="mb-4">Editar Producto</h2>
            
            <!-- Formulario para editar -->
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['id']; ?>" <?php echo ($categoria['id'] == $producto['categoria_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if (!empty($producto['imagen'])): ?>
                    <div class="mb-3">
                        <label class="form-label">Imagen actual:</label><br>
                        <img src="assets/productos/<?php echo $producto['imagen']; ?>" alt="Imagen actual" class="img-thumbnail" width="200">
                        <a href="producto.php?id=<?php echo $producto['id']; ?>&eliminar_imagen=1" class="btn btn-sm btn-outline-danger mt-2">Eliminar Imagen</a>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="imagen" class="form-label">Nueva Imagen (opcional)</label>
                    <input type="file" class="form-control" id="imagen" name="imagen">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <a href="dashboard.php" class="btn btn-secondary">Volver al panel</a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                    <div>
                        <button type="submit" name="eliminar_producto" value="1" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');">Eliminar Producto</button>
                    </div>
                </div>
            </form>

        <?php else: ?>
            <div class="alert alert-danger">Producto no encontrado.</div>
        <?php endif; ?>
    </div>

    <!-- Footer-->
    <?php include 'components/footer.php'; ?>
</body>
</html>

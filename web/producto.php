<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (!isset($_SESSION['rol_id'])) {
	header('Location: login.php');
	exit();
}

include 'functions/editar_producto.php';

$rol_id = $_SESSION['rol_id'] ?? 2; // Por defecto, rol usuario
$rol = ($rol_id == 1) ? 'admin' : 'usuario';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $rol === 'admin' ? 'Editar Producto' : 'Ver Producto'; ?></title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navigation-->
<?php include 'components/header.php'; ?>

<div class="container py-5">
    <?php if ($producto): ?>
        <h2 class="mb-4"><?php echo $rol === 'admin' ? 'Editar Producto' : 'Ver Producto'; ?></h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control rounded-16" id="nombre" name="nombre"
                       value="<?php echo htmlspecialchars($producto['nombre']); ?>"
                       <?php echo $rol === 'admin' ? '' : 'readonly'; ?> required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control rounded-16" id="descripcion" name="descripcion" rows="3"
                          <?php echo $rol === 'admin' ? '' : 'readonly'; ?> required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control rounded-16" id="precio" name="precio"
                       value="<?php echo $producto['precio']; ?>"
                       <?php echo $rol === 'admin' ? '' : 'readonly'; ?> required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select rounded-16" id="categoria" name="categoria"
                        <?php echo $rol === 'admin' ? '' : 'disabled'; ?> required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id']; ?>"
                            <?php echo ($categoria['id'] == $producto['categoria_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (!empty($producto['imagen'])): ?>
                <div class="mb-3">
                    <label class="form-label">Imagen actual:</label><br>
                    <img src="assets/productos/<?php echo $producto['imagen']; ?>" alt="Imagen actual"
                         class="img-thumbnail rounded-16" width="200">
                    <?php if ($rol === 'admin'): ?>
                        <a href="producto.php?id=<?php echo $producto['id']; ?>&eliminar_imagen=1"
                           class="btn btn-sm btn-outline-danger mt-2 rounded-16 ms-3">Eliminar Imagen</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($rol === 'admin'): ?>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Nueva Imagen (opcional)</label>
                    <input type="file" class="form-control rounded-16" id="imagen" name="imagen">
                </div>
            <?php endif; ?>

            <?php if ($rol === 'admin'): ?>
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <a onclick="history.back();" class="btn btn-secondary rounded-20">Volver Atrás</a>
                        <button type="submit" class="btn btn-primary rounded-20">Guardar Cambios</button>
                    </div>
                    <div>
                        <button type="submit" name="eliminar_producto" value="1"
                                class="btn btn-danger rounded-20"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');">
                            Eliminar Producto
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <a onclick="history.back();" class="btn btn-secondary rounded-20">Volver Atrás</a>
            <?php endif; ?>

            <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'dashboard.php'); ?>">
        </form>

    <?php else: ?>
        <div class="alert alert-danger">Producto no encontrado.</div>
    <?php endif; ?>
</div>

<!-- Footer-->
<?php include 'components/footer.php'; ?>

</body>
</html>

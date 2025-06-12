<?php
include 'utils/conexion.php';

$mensaje = "";
$upload_dir = "assets/categorias/";

// Agregar nueva categoría con imagen
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nueva_categoria'])) {
    $nuevo_nombre = trim($_POST['nueva_categoria']);
    $img_nombre = null;

    if (!empty($nuevo_nombre)) {
        // Guardar imagen si se sube
        if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['nueva_imagen']['tmp_name'];
            $img_nombre = basename($_FILES['nueva_imagen']['name']);
            move_uploaded_file($tmp_name, $upload_dir . $img_nombre);
        }

        $stmt = $conexion->prepare("INSERT INTO categorias (nombre, img_url) VALUES (?, ?)");
        $stmt->bind_param("ss", $nuevo_nombre, $img_nombre);
        $stmt->execute();
        $stmt->close();

        $mensaje = "Nueva categoría agregada correctamente.";
        header("Location: editar_categoria.php?msg=" . urlencode($mensaje));
        exit();
    } else {
        $mensaje = "El nombre de la nueva categoría no puede estar vacío.";
        header("Location: editar_categoria.php?msg=" . urlencode($mensaje));
        exit();
    }
}

// Guardado masivo (solo nombre, no imagen)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['guardar_todo'])) {
    // Actualizar nombres
    foreach ($_POST['nombre'] as $id => $nuevo_nombre) {
        $stmt = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nuevo_nombre, $id);
        $stmt->execute();
        $stmt->close();
    }

    // Actualizar imágenes
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

    $mensaje = "Categorías actualizadas correctamente.";
    header("Location: editar_categoria.php?msg=" . urlencode($mensaje));
    exit();
}

// Eliminar categoría
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $mensaje = "Categoría eliminada correctamente.";
    header("Location: editar_categoria.php?msg=" . urlencode($mensaje));
    exit();
}

// Obtener categorías
$categorias2 = [];
$resultado = $conexion->query("SELECT id, img_url, nombre FROM categorias");
while ($cat = $resultado->fetch_assoc()) {
    $categorias2[] = $cat;
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categorías</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'components/header.php'; ?>

<div class="container py-5">
    <h2 class="mb-4">Administrar Categorías</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>

    <!-- Formulario para agregar nueva categoría -->
    <form method="POST" class="mb-4 d-flex gap-2" enctype="multipart/form-data">
        <input type="text" name="nueva_categoria" class="form-control" placeholder="Nueva categoría..." required>
        <input type="file" name="nueva_imagen" accept="image/*" class="form-control">
        <button type="submit" class="btn btn-success">Agregar</button>
    </form>

    <!-- Formulario para editar/eliminar -->
    <form method="POST" enctype="multipart/form-data">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Categoría</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias2 as $cat): ?>
                    
                    <tr>
                        <td><?php echo $cat['id']; ?></td>
                        <td>
                            <input type="text" class="form-control" name="nombre[<?php echo $cat['id']; ?>]" value="<?php echo htmlspecialchars($cat['nombre']); ?>" required>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-4">
                                <?php if (!empty($cat['img_url'])): ?>
                                    <img src="assets/categorias/<?php echo htmlspecialchars($cat['img_url']); ?>" alt="Imagen categoría" width="60">
                                <?php else: ?>
                                    <span class="text-muted">Sin imagen</span>
                                <?php endif; ?>

                                <input type="file" name="imagen_actualizada[<?php echo $cat['id']; ?>]" accept="image/*" class="form-control form-control-sm" style="max-width: 200px;">
                            </div>
                        </td>
                        <td>
                            <a href="?eliminar=<?php echo $cat['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta categoría?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex gap-2">
            <a onclick="history.back();" class="btn btn-secondary">Volver Atrás</a>
            <button type="submit" name="guardar_todo" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<?php include 'components/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let cambiosSinGuardar = false;

    // Detectar cambios en cualquier input, select o textarea
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('change', () => {
            cambiosSinGuardar = true;
        });
    });

    // Si se envía el formulario, se desactiva la advertencia
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            cambiosSinGuardar = false;
        });
    });

    // Prevenir navegación si hay cambios no guardados
    window.addEventListener('beforeunload', function (e) {
        if (cambiosSinGuardar) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
});
</script>

</body>
</html>

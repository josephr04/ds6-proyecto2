<?php
include 'utils/conexion.php';
$mensaje = "";

// Agregar nueva categoría
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nueva_categoria'])) {
    $nuevo_nombre = trim($_POST['nueva_categoria']);

    if (!empty($nuevo_nombre)) {
        $stmt = $conexion->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        $stmt->bind_param("s", $nuevo_nombre);
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

// Guardado masivo
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['guardar_todo'])) {
    foreach ($_POST['nombre'] as $id => $nuevo_nombre) {
        $stmt = $conexion->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nuevo_nombre, $id);
        $stmt->execute();
        $stmt->close();
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
$categorias = [];
$resultado = $conexion->query("SELECT id, nombre FROM categorias");
while ($cat = $resultado->fetch_assoc()) {
    $categorias[] = $cat;
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categorías</title>
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
    <form method="POST" class="mb-4 d-flex gap-2">
        <input type="text" name="nueva_categoria" class="form-control" placeholder="Nueva categoría..." required>
        <button type="submit" class="btn btn-success">Agregar</button>
    </form>

    <!-- Formulario para editar/eliminar -->
    <form method="POST">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?php echo $categoria['id']; ?></td>
                        <td>
                            <input type="text" class="form-control" name="nombre[<?php echo $categoria['id']; ?>]" value="<?php echo htmlspecialchars($categoria['nombre']); ?>" required>
                        </td>
                        <td>
                            <a href="?eliminar=<?php echo $categoria['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta categoría?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex gap-2">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Panel</a>
            <button type="submit" name="guardar_todo" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<?php include 'components/footer.php'; ?>
</body>
</html>

<?php
include 'functions/editar_producto.php';
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
							<a onclick="history.back();" class="btn btn-secondary">Volver Atrás</a>
							<button type="submit" class="btn btn-primary">Guardar Cambios</button>
						</div>
						<div>
							<button type="submit" name="eliminar_producto" value="1" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');">Eliminar Producto</button>
						</div>
					</div>

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

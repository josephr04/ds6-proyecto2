<?php
session_start(); // Inicia sesión para acceder a $_SESSION

// Verifica si el usuario está logueado y es administrador
if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
	// Redirigir a otra página, por ejemplo el dashboard o login
	header('Location: ../web/dashboard.php');
	exit; // Importante para detener la ejecución
}

include 'functions/crear_prod.php';
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Crear Producto</title>
		<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<?php include 'components/header.php'; ?>

		<div class="container py-5">
			<h2 class="mb-4">Agregar Nuevo Producto</h2>

			<?php if ($mensaje): ?>
				<div class="alert alert-success rounded-20"><?php echo $mensaje; ?></div>
			<?php endif; ?>

			<form method="POST" enctype="multipart/form-data">
				<div class="mb-3">
					<label for="nombre" class="form-label">Nombre del Producto</label>
					<input type="text" class="form-control rounded-16" id="nombre" name="nombre" required>
				</div>

				<div class="mb-3">
					<label for="descripcion" class="form-label">Descripción</label>
					<textarea class="form-control rounded-16" id="descripcion" name="descripcion" rows="3" required></textarea>
				</div>

				<div class="mb-3">
					<label for="precio" class="form-label">Precio</label>
					<input type="number" step="0.01" class="form-control rounded-16" id="precio" name="precio" required>
				</div>

				<div class="mb-3">
					<label for="categoria" class="form-label">Categoría</label>
					<select class="form-select rounded-16" id="categoria" name="categoria" required>
						<?php foreach ($categorias as $cat): ?>
							<option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="mb-3">
					<label for="imagen" class="form-label">Imagen del Producto</label>
					<input type="file" class="form-control rounded-16" id="imagen" name="imagen">
				</div>

				<input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'dashboard.php'); ?>">
				<a onclick="history.back();" class="btn btn-secondary rounded-20 mt-2">Cancelar</a>
				<button type="submit" class="btn btn-primary rounded-20 mt-2">Crear Producto</button>
			</form>
		</div>

		<?php include 'components/footer.php'; ?>
	</body>
</html>

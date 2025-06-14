<?php
session_start();

if (!isset($_SESSION['rol_id'])) {
	header('Location: login.php');
	exit();
}

if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
	header('Location: ../web/dashboard.php');
	exit;
}

include 'functions/editar_categorias.php'
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar Categorías</title>
		<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<?php include 'components/header.php'; ?>

		<div class="container py-5">
			<h2 class="mb-4">Administrar Categorías</h2>

			<?php if (isset($_GET['msg'])): ?>
					<div class="alert alert-success rounded-20"><?php echo htmlspecialchars($_GET['msg']); ?></div>
			<?php endif; ?>

			<!-- Formulario para agregar nueva categoría -->
			<form method="POST" class="mb-4 d-flex gap-2" enctype="multipart/form-data">
					<input type="text" name="nueva_categoria" class="form-control rounded-16" placeholder="Nueva categoría..." required>
					<input type="file" name="nueva_imagen" accept="image/*" class="form-control rounded-16">
					<button type="submit" class="btn btn-success rounded-20">Agregar</button>
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
									<input type="text" class="form-control rounded-16" name="nombre[<?php echo $cat['id']; ?>]" value="<?php echo htmlspecialchars($cat['nombre']); ?>" required>
								</td>
								<td>
									<div class="d-flex align-items-center gap-4">
										<?php if (!empty($cat['img_url'])): ?>
											<img src="assets/categorias/<?php echo htmlspecialchars($cat['img_url']); ?>" alt="Imagen categoría" width="60">
										<?php else: ?>
											<span class="text-muted">Sin imagen</span>
										<?php endif; ?>

										<input type="file" name="imagen_actualizada[<?php echo $cat['id']; ?>]" accept="image/*" class="form-control form-control-sm rounded-16" style="max-width: 200px;">
									</div>
								</td>
								<td>
									<a href="?eliminar=<?php echo $cat['id']; ?>" class="btn btn-danger btn-sm rounded-20" onclick="return confirm('¿Seguro que quieres eliminar esta categoría?');">Eliminar</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<div class="d-flex gap-2 mt-4">
					<a onclick="history.back();" class="btn btn-secondary rounded-20">Volver Atrás</a>
					<button type="submit" name="guardar_todo" class="btn btn-primary rounded-20">Guardar Cambios</button>
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

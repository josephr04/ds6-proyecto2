<?php
include 'functions/obtener_categorias.php';
?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container px-4 px-lg-5">

		<a class="navbar-brand" href="../web/dashboard.php">TecnoMarket</a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">

			<ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
				<li class="nav-item"><a class="nav-link active" aria-current="page" href="../web/dashboard.php">Inicio</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Administrar</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="../web/productos.php">Todos los productos</a></li>
						<li><hr class="dropdown-divider"/></li>
						<li class="dropdown-submenu">
							<a class="dropdown-item dropdown-toggle d-flex justify-content-between align-items-center" href="#" role="button">Ver Categorías</a>
							<ul class="dropdown-menu">
								<?php foreach ($categorias as $categoria): ?>
									<li><a class="dropdown-item" href="categoria.php?id=<?php echo $categoria['id']; ?>">
										<?php echo htmlspecialchars($categoria['nombre']); ?>
									</a></li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li><a class="dropdown-item" href="../web/gestionar_categorias.php">Gestionar Categorías</a></li>
						<li><a class="dropdown-item" href="../web/crear_producto.php">Agregar Producto</a></li>
					</ul>
				</li>
			</ul>

			<div class="d-flex">
				<div class="dropdown">
					<button class="btn btn-outline-dark dropdown-toggle" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-person-fill"></i>
						Administrador
					</button>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
						<li><a class="dropdown-item text-danger" href="../web/auth/logout.php">Cerrar Sesión  <i class="bi bi-box-arrow-right ms-2"></i></a></li>
					</ul>
				</div>

			</div>
		</div>
	</div>
</nav>

<script src="../assets/js/navbar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

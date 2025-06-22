<?php
session_start();

if (!isset($_SESSION['rol_id'])) {
	header('Location: login.php');
	exit();
}

include 'functions/mostrar_productos.php';
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los productos - TecnoMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <!-- Navigation-->
    <?php include 'components/header.php'; ?>

      <!-- Header-->
      <header class="bg-dark py-2">
        <div class="container px-4 px-lg-5 my-5">
          <div class="text-center text-white">
            <h1 class="display-6 fw-bolder">Lista de Productos</h1>
            <p class="lead fw-normal text-white-50 mb-0">
              <?php echo $total_productos; ?> Resultado<?php echo $total_productos !== 1 ? 's' : ''; ?>
            </p>
          </div>
        </div>
      </header>

    <section class="py-3">
			<?php
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				if (isset($_SESSION['success_message'])) {
					echo '<div class="container mt-3 w-50"><div class="alert alert-success rounded-20 text-center">' . htmlspecialchars($_SESSION['success_message']) . '</div></div>';
					unset($_SESSION['success_message']);
				}
				if (isset($_SESSION['error_message'])) {
					echo '<div class="container mt-3 w-50"><div class="alert alert-danger rounded-20 text-center">' . htmlspecialchars($_SESSION['error_message']) . '</div></div>';
					unset($_SESSION['error_message']);
				}
			?>

      <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
          <?php foreach ($productos as $producto): ?>
            <?php
              $nombre = $producto['nombre'];
              $precio = $producto['precio'];
              $id = $producto['id'];

              if (!empty($producto['imagen'])) {
                $imagen = './../imagenes/productos/' . $producto['imagen'];
              } else {
                $imagen = "https://dummyimage.com/456x399/dee2e6/000000.png?text=" . urlencode($nombre);
              }

              include 'components/card.php';
            ?>
          <?php endforeach; ?>
        </div>

        <!-- Navegación de páginas -->
        <nav aria-label="Page navigation" class="mt-5 mb-5">
          <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
              <li class="page-item <?php echo ($i === $pagina_actual) ? 'active' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $i; ?>"> <?php echo $i; ?> </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      </div>
    </section>

    <!-- Footer-->
    <?php include 'components/footer.php'; ?>

    <script src="js/scripts.js"></script>
  </body>
</html>

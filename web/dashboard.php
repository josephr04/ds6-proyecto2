<?php
include 'utils/conexion.php';

$productos = [];

$sql = "SELECT id, nombre, precio, img_url AS imagen FROM productos";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
} else {
    // Puedes mostrar mensaje o dejar el array vacío
    // echo "No se encontraron productos.";
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="styles.css" rel="stylesheet" />
    </head>
    <body>

        <!-- Navigation-->
        <?php include 'components/header.php'; ?>

        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">TecnoMarket</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Tienda de tecnología y electrónica</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php foreach ($productos as $producto): ?>
                        <?php
                        $nombre = $producto['nombre'];
                        $precio = $producto['precio'];
                        $id = $producto['id'];

                        if (!empty($producto['imagen'])) {
                            $imagen = '../web/assets/productos/' . $producto['imagen'];
                        } else {
                            $imagen = "https://dummyimage.com/456x399/dee2e6/000000.png?text=" . urlencode($nombre);
                        }

                        include 'components/card.php';
                        ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <?php include 'components/footer.php'; ?>

        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php
include 'utils/conexion.php';

// Obtener categorías
$categorias = [];
$sql_categorias = "SELECT id, nombre FROM categorias"; // Ajusta según tu estructura de tabla
$resultado_categorias = $conexion->query($sql_categorias);

if ($resultado_categorias && $resultado_categorias->num_rows > 0) {
    while ($fila = $resultado_categorias->fetch_assoc()) {
        $categorias[] = $fila;
    }
}

$conexion->close();
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
                        <li><a class="dropdown-item" href="#!">Todos los productos</a></li>
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
                        <li><a class="dropdown-item" href="../web/editar_categoria.php">Gestionar Categorías</a></li>
                        <li><a class="dropdown-item" href="../web/crear_producto.php">Crear Producto</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <button class="btn btn-outline-dark" type="submit">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<style>
    .dropdown-submenu {
        position: relative;
    }
    
    .dropdown-submenu > .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -6px;
        margin-left: -1px;
        display: none;
    }
    
    .dropdown-submenu:hover > .dropdown-menu {
        display: block;
    }
    
    .dropdown-submenu > a:after {
        display: block;
        content: " ";
        float: right;
        width: 0;
        height: 0;
        border-color: transparent;
        border-style: solid;
        border-width: 5px 0 5px 5px;
        border-left-color: #000;
        margin-top: 5px;
        margin-right: -10px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar los dropdowns anidados
    var dropdownElements = document.querySelectorAll('.dropdown-submenu');
    
    dropdownElements.forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.stopPropagation();
            var submenu = this.querySelector('.dropdown-menu');
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        });
    });
    
    // Cerrar los submenús cuando se hace clic fuera
    document.addEventListener('click', function() {
        dropdownElements.forEach(function(el) {
            el.querySelector('.dropdown-menu').style.display = 'none';
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

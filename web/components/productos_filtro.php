<?php
include 'utils/conexion.php';
$categorias3 = $conexion->query("SELECT id, nombre FROM categorias");
?>
<div class="container mt-4">
    <div class="row">
        <!-- Categorías -->
        <div class="col-md-3">
            <h5>Categorías</h5>
            <form id="form-categorias">
                <?php while ($cat = $categorias3->fetch_assoc()): ?>
                    <div class="form-check">
                        <input class="form-check-input categoria-checkbox" type="checkbox" name="categorias[]" value="<?= $cat['id']; ?>" id="cat<?= $cat['id']; ?>">
                        <label class="form-check-label" for="cat<?= $cat['id']; ?>">
                            <?= htmlspecialchars($cat['nombre']); ?>
                        </label>
                    </div>
                <?php endwhile; ?>
            </form>
        </div>

        <!-- Productos -->
        <div class="col-md-9">
            <div id="productos-lista">
                <p class="text-muted">Selecciona una o más categorías.</p>
            </div>
        </div>
    </div>
</div>
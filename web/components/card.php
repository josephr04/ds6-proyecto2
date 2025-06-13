<!-- card.php -->
<div class="col mb-5">
  <div class="card h-100 rounded-20">
		<!-- Product image-->
		<div class="img-container">
			<img class="card-img-top" src="<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>" />
		</div>
		<!-- Product details-->
		<div class="card-body p-4" style="border-top: 1px solid #ddd;">
			<div class="text-center">
				<!-- Product name-->
				<h5 class="fw-bolder"><?php echo $nombre; ?></h5>
				<!-- Product reviews-->
				<div class="d-flex justify-content-center small text-warning mb-2">
					<div class="bi-star-fill"></div>
					<div class="bi-star-fill"></div>
					<div class="bi-star-fill"></div>
					<div class="bi-star-fill"></div>
					<div class="bi-star-fill"></div>
				</div>
				<!-- Product price-->
				$<?php echo number_format($precio, 2); ?>
			</div>
		</div>
		<!-- Product actions-->
		<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
			<div class="text-center">
				<a class="btn btn-outline-dark w-50 mt-auto rounded-20" href="../web/producto.php?id=<?php echo $id; ?>">
					<?php
						if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 1) {
							echo 'Editar <i class="bi bi-pencil ms-2"></i>';
						} else {
							echo 'Ver <i class="bi bi-eye ms-2"></i>';
						}
					?>
				</a>
			</div>
		</div>
  </div>
</div>

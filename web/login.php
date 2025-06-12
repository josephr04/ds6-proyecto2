<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login Form Responsive</title>
		<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css">
	</head>
	<body class="bg-dark">
		<!-- Login 3 - Bootstrap Brain Component -->
		<section class="p-3 p-md-4 p-xl-5">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-6 bsb-tpl-bg-platinum rounded-start">
							<div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
									<h3 class="m-0">Bienvenido!</h3>
									<img class="img-fluid rounded mx-auto my-4" loading="lazy" src="./assets/img/bsb-logo.svg" width="245" height="80" alt="BootstrapBrain Logo">
							</div>
					</div>
					<div class="col-12 col-md-6 bsb-tpl-bg-lotion rounded-end">
						<div class="p-3 p-md-6 p-xl-5">
						<div class="row">
							<div class="col-12">
								<div class="mb-5">
									<h3>Iniciar Sesión</h3>
								</div>
							</div>
						</div>
						<form action="auth/procesar_login.php" method="POST">
							<div class="row gy-3 gy-md-4 overflow-hidden">
								<div class="col-12">
									<label for="email" class="form-label">Correo <span class="text-danger">*</span></label>
									<input type="email" class="form-control" name="correo_institucional" id="email" placeholder="name@example.com" required>
								</div>
								<div class="col-12">
									<label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
									<input type="password" class="form-control" name="contrasena" id="password" value="" required>
								</div>
								<div class="col-12">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
										<label class="form-check-label text-secondary" for="remember_me">
												Mantenerme conectado
										</label>
									</div>
								</div>
								<div class="col-12">
									<div class="d-grid">
										<button class="btn bsb-btn-xl btn-primary" type="submit">Iniciar Sesión</button>
									</div>
								</div>

								<?php if (isset($_GET['error'])): ?>
									<div class="text-danger text-center">
										<?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
									</div>
								<?php endif; ?>
							</div>
						</form>
						<div class="row">
							<div class="col-12">
								<hr class="mt-5 mb-4 border-secondary-subtle">
								<div class="text-end">
									<a href="#!" class="link-secondary text-decoration-none">Forgot password</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</body>
</html>
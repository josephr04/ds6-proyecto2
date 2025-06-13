<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-3/assets/css/login-3.css" />
  <link rel="stylesheet" href="../web/styles.css" />
  <style>
    .login-layout {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 1rem;
    }

    .login-box {
      display: flex;
      background-color: white;
      border-radius: 20px;
      overflow: hidden;
      max-width: 960px;
      width: 100%;
    }

    .login-left, .login-right {
      flex: 1;
      padding: 2rem;
    }

    .login-left {
      background-color: #e6e6e6;
    }

    .login-right {
      background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
      .login-box {
        flex-direction: column;
      }
    }
  </style>
</head>
<body class="bg-dark">
  <section class="login-layout">
    <div class="login-box">
      <div class="login-left rounded-start roundedl-20">
				<div class="d-flex flex-column h-100 justify-content-center align-items-start p-3 p-md-4 p-xl-5">
          <h3 class="mb-5">Bienvenido!</h3>
          <img class="img-fluid rounded mx-auto my-4 rounded-20" loading="lazy" src="./assets/img/tecnomarket_logo.png" width="300" height="97" alt="BootstrapBrain Logo" />
        </div>
      </div>

      <div class="login-right rounded-end roundedr-20">
        <div class="p-3 p-md-4 p-xl-5">
          <div class="mb-5">
            <h3>Iniciar Sesión</h3>
          </div>
          <form action="auth/procesar_login.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Correo <span class="text-danger">*</span></label>
              <input type="email" class="form-control rounded-16" name="correo_institucional" id="email" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
              <input type="password" class="form-control rounded-16" name="contrasena" id="password" required>
            </div>
						<div class="mb-3 form-check">
							<input class="form-check-input custom-checkbox rounded-16" type="checkbox" value="" name="remember_me" id="remember_me">
							<label class="form-check-label text-secondary" for="remember_me">
									Mantenerme conectado
							</label>
						</div>
            <div class="d-grid mb-3">
              <button class="btn btn-outline-dark rounded-20" type="submit">Iniciar Sesión</button>
            </div>
            <?php if (isset($_GET['error'])): ?>
              <div class="text-danger text-center">
                <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
              </div>
            <?php endif; ?>
          </form>
          <hr class="mt-5 mb-4 border-secondary-subtle">
          <div class="text-end">
            <a href="#!" class="link-secondary text-decoration-none">¿Olvidaste tu contraseña?</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>

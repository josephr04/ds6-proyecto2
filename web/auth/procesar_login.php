<?php
include '../utils/conexion.php';
session_start();

if (isset($_POST['correo_institucional']) && isset($_POST['contrasena'])) {
    $correo = $_POST['correo_institucional'];
    $contrasena = $_POST['contrasena'];

    $correo = htmlspecialchars(trim($correo), ENT_QUOTES, 'UTF-8');
    $contrasena = htmlspecialchars(trim($contrasena), ENT_QUOTES, 'UTF-8');

    // Consultar SQL para verificar el usuario
    $stmt = $conexion->prepare("SELECT id, rol_id, contraseña FROM usuarios WHERE correo_institucional = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña ingresada con la contraseña hasheada
        if (password_verify($contrasena, $usuario['contraseña'])) {
            session_regenerate_id(true);
            $_SESSION['correo_institucional'] = $correo;
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['rol_id'] = $usuario['rol_id'];

            // Redirigir según el rol
            if ($usuario['rol_id'] == 1) {
                header("Location: ../dashboard.php"); // página de administrador
            } elseif ($usuario['rol_id'] == 2) {
                header("Location: ../dashboard.php"); // página de usuario
            } else {
                header("Location: ../login.php?error=Rol no reconocido.");
            }
            exit();
        } else {
            header("Location: ../login.php?error=Correo o contraseña incorrectos. Por favor, intente de nuevo.");
            exit();
        }
    } else {
        header("Location: ../login.php?error=Usuario no encontrado.");
        exit();
    }

    $stmt->close();
} else {
    header("Location: ../login.php?error=Hay campos vacíos.");
    exit();
}
?>
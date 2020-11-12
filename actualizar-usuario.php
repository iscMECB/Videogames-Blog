<?php
if (isset($_POST)) {
    // Conexion a bd
    require_once 'includes/conexion.php';

    // Recoger los valores del formulario de actualizacion
    $nombre = !empty($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = !empty($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = !empty($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;

    // Array de errores
    $errores = [];

    // Validar los datos antes de guardarlos en DB

    // Validar el nombre
    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombre_validado = true;
    } else {
        $nombre_validado = false;
        $errores['nombre'] = 'El nombre no es válido';
    }

    // Validar los apellidos
    if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $email)) {
        $apellidos_validado = true;
    } else {
        $apellidos_validado = false;
        $errores['apellidos'] = 'Los apellidos no son válido';
    }

    // Validar el email
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_validado = true;
    } else {
        $email_validado = false;
        $errores['email'] = 'El email no es válido';
    }

    $guardar_usuario = false;

    if (empty($errores)) {
        $usuario = $_SESSION['usuario']['id'];
        $guardar_usuario = true;

        // COMPROBAR SI EL EMAIL YA EXISTE
        $sql = "SELECT id, email FROM usuarios WHERE email = '$email'";
        $isset_email = mysqli_query($db, $sql);
        $isset_user = mysqli_fetch_assoc($isset_email);

        if ($isset_user['id'] == $usuario || empty($isset_user)) {
            // ACTUALIZAR USUARIO EN LA DB EN LA TABLA USUARIOS
            $sql = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', email = '$email' WHERE id = $usuario";
            $guardar = mysqli_query($db, $sql);

            if ($guardar) {
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;
                $_SESSION['completado'] = "Tus datos se han actualizado con exito!!";
            } else {
                $_SESSION['errores']['general'] = "Fallo al actualizar tus datos";
            }
        } else {
            $_SESSION['errores']['general'] = "El email ya existe";
        }
    } else {
        $_SESSION['errores'] = $errores;
    }
}
header('Location: mis-datos.php');

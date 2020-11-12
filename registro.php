<?php
if (isset($_POST)) {
    // Conexion a bd
    require_once 'includes/conexion.php';

    // Recoger los valores del formulario de registro
    $nombre = !empty($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = !empty($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = !empty($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = !empty($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

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

    // Validar la password
    if (!empty($password)) {
        $password_validado = true;
    } else {
        $password_validado = false;
        $errores['password'] = 'La password esta vacia';
    }

    $guardar_usuario = false;

    if (empty($errores)) {
        $guardar_usuario = true;

        // Cifrar la contraseña
        $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
        //var_dump($password_segura);

        // INSERTAR USUARIO EN LA DB EN LA TABLA USUARIOS
        $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', CURDATE())";
        $guardar = mysqli_query($db, $sql);

        /* var_dump(mysqli_error($db));
        die(); */
        if ($guardar) {
            $_SESSION['completado'] = "El registro se ha completado con exito!!";
        } else {
            $_SESSION['errores']['general'] = "Fallo al guardar el usuario";
        }
    } else {
        $_SESSION['errores'] = $errores;
    }
}
header('Location: index.php');







/* echo $nombre . '<br>';
echo $apellidos . '<br>';
echo $email . '<br>';
echo $password . '<br>'; */

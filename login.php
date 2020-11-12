<?php
// Iniciar la sesion y la conexion a la DB
require_once 'includes/conexion.php';

// Recoger datos del formulario
if (isset($_POST['login'])) {
    $email = !empty($_POST['email']) ? $_POST['email'] : false;
    $password = !empty($_POST['password']) ? $_POST['password'] : false;

    // Consulta para comprobar si el email y la contraseña coincidad
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $login = mysqli_query($db, $sql);

    if ($login && mysqli_num_rows($login) == 1) {
        $usuario = mysqli_fetch_assoc($login);

        // Comprobar la contraseña / Cifrar
        $verify = password_verify($password, $usuario['password']);

        if ($verify) {
            // Utilizar sesion para guardar los datos del usuario logueado
            $_SESSION['usuario'] = $usuario;

            if (isset($_SESSION['error_login'])) {
                unset($_SESSION['error_login']);
            }
        } else {
            // Si algo falla, enviar una sesion con el fallo
            $_SESSION['error_login'] = "Login incorrecto!!";
        }
    } else {
        // Mensaje de error
        $_SESSION['error_login'] = "Login incorrecto!!";
    }
}

// Redirigir al index
header('Location: index.php');

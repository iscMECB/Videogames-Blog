<?php
if (isset($_POST)) {
    // Conexion a bd
    require_once 'includes/conexion.php';

    $nombre = !empty($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;

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

    if (empty($errores)) {
        $sql = "INSERT INTO categorias VALUES(null, '$nombre')";
        $guardar = mysqli_query($db, $sql);
    }
}
header('Location: index.php');

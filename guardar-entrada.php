<?php
if (isset($_POST)) {
    // Conexion a bd
    require_once 'includes/conexion.php';

    // Guardar datos del formulario
    $titulo = !empty($_POST['titulo']) ? mysqli_real_escape_string($db, $_POST['titulo']) : false;
    $descripcion = !empty($_POST['descripcion']) ? mysqli_real_escape_string($db, $_POST['descripcion']) : false;
    $categoria = !empty($_POST['categoria']) ? (int)$_POST['categoria'] : false;
    $usuario = $_SESSION['usuario']['id'];

    // Array de errores
    $errores = [];

    // Validar los datos antes de guardarlos en DB
    // Validar el nombre
    if (empty($titulo)) {
        $errores['titulo'] = 'El titulo no es válido';
    }

    if (empty($descripcion)) {
        $errores['descripcion'] = 'La descripcion no es válida';
    }

    if (empty($categoria) || !is_int($categoria)) {
        $errores['categoria'] = 'La categoria no es válida';
    }

    if (empty($errores)) {
        if (isset($_GET['editar'])) {
            $entrada_id = $_GET['editar'];
            $usuario_id = $_SESSION['usuario']['id'];
            $sql = "UPDATE entradas SET titulo='$titulo', descripcion='$descripcion', categoria_id=$categoria WHERE id=$entrada_id AND usuario_id=$usuario_id";
        } else {
            $sql = "INSERT INTO entradas VALUES(null, $usuario, $categoria, '$titulo', '$descripcion', CURDATE())";
        }

        $guardar = mysqli_query($db, $sql);
        header('Location: index.php');
    } else {
        $_SESSION['errores_entrada'] = $errores;
        if (isset($_GET['editar'])) {
            header('Location: editar-entrada.php?id=' . $_GET['editar']);
        } else {

            header('Location: crear-entradas.php');
        }
    }
}

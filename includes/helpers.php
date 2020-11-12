<?php

function mostrarError($errores, $campo)
{
    $alerta = '';
    if (!empty($errores[$campo])) {
        $alerta = "<div class='alerta alerta-error'>" . $errores[$campo] . '</div>';
    }

    return $alerta;
}

function borrarErrores()
{
    $borrado = false;
    if (isset($_SESSION['errores'])) {
        unset($_SESSION['errores']);
        /* $_SESSION['errores'] = null; */
    }

    if (isset($_SESSION['completado'])) {
        unset($_SESSION['completado']);
    }

    if (isset($_SESSION['errores_entrada'])) {
        unset($_SESSION['errores_entrada']);
    }
    return $borrado;
}

function conseguirCategorias($db)
{
    $sql = "SELECT * FROM categorias";
    $categorias = mysqli_query($db, $sql);
    $resultado = array();

    if ($categorias && mysqli_num_rows($categorias) >= 1) {
        $resultado = $categorias;
    }

    return $resultado;
}

function conseguirCategoria($db, $id)
{
    $sql = "SELECT * FROM categorias WHERE id = $id";
    $categorias = mysqli_query($db, $sql);
    $resultado = array();

    if ($categorias && mysqli_num_rows($categorias) >= 1) {
        $resultado = mysqli_fetch_assoc($categorias);
    }

    return $resultado;
}

function conseguirEntrada($db, $id)
{
    $sql = "SELECT e.*, c.nombre AS 'categoria', CONCAT(u.nombre, ' ', u.apellidos) AS 'usuario' FROM entradas e 
    INNER JOIN categorias c ON c.id = e.categoria_id 
    INNER JOIN usuarios u ON e.usuario_id = u.id 
    WHERE e.id = $id";

    $entrada = mysqli_query($db, $sql);

    $resultado = [];
    if ($entrada) {
        $resultado = mysqli_fetch_assoc($entrada);
    }

    return $resultado;
}

function conseguirEntradas($db, $limit = null, $categoria = null, $busqueda = null)
{
    $sql = "SELECT e.*, c.nombre AS 'categoria' FROM entradas e
    INNER JOIN categorias c ON e.categoria_id = c.id";

    if ($categoria) {
        $sql .= " WHERE e.categoria_id = $categoria";
    }

    if ($busqueda) {
        $sql .= " WHERE e.titulo LIKE '%$busqueda%'";
    }

    $sql .= " ORDER BY e.id DESC";

    if ($limit) {
        $sql .= " LIMIT 4";
    }

    $entradas = mysqli_query($db, $sql);

    $resultado = array();
    if ($entradas && mysqli_num_rows($entradas) >= 1) {
        $resultado = $entradas;
    }

    return $resultado;
}

/* $passwordCifrada = !empty($_POST['cadena']) ? $_POST['cadena'] : false;

$sql = "SELECT Password FROM passwords WHERE Password = '$passwordCifrada'";
$select = mysqli_query($db, $sql);

foreach ($select as $key => $value) {
    $resultado[$key] = $value;
}
echo json_encode($resultado); */

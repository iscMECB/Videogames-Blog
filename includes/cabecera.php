<?php require_once 'conexion.php'; ?>
<?php require_once 'helpers.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog de Videojuegos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- HEADER -->
    <header id="cabecera">
        <!-- LOGO -->
        <div id="logo">
            <a href="index.php">
                BLOG DE VIDEOJUEGOS
            </a>
        </div>

        <div class="clearfix"></div>
        <!-- MENU -->
        <nav id="menu">
            <div id="menu">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <?php
                    $categorias = conseguirCategorias($db);

                    if (!empty($categorias)) :

                        while ($categoria = mysqli_fetch_assoc($categorias)) :
                    ?>
                            <li><a href="categoria.php?id=<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></a></li>
                    <?php
                        endwhile;
                    endif;
                    ?>
                    <li><a href="#">Sobre nosotros</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
        </nav>
        <div class="clearfix"></div>
    </header>
    <div id="contenedor">
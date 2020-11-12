<?php require_once './includes/cabecera.php'; ?>
<?php require_once './includes/redireccion.php'; ?>


<?php
$entrada_actual = conseguirEntrada($db, $_GET['id']);
if (!isset($entrada_actual['id'])) {
    header("Location: index.php");
}
?>

<?php require_once './includes/lateral.php'; ?>

<!-- MAIN -->
<main id="principal">
    <h1>Editar entradas</h1>
    <p>
        Edita tu entrada <?= $entrada_actual['titulo']; ?>
    </p><br>

    <form action="guardar-entrada.php?editar=<?= $entrada_actual['id']; ?>" method="POST">
        <label for="titulo">Titulo</label>
        <input type="text" name="titulo" value="<?= $entrada_actual['titulo']; ?>">
        <?php echo isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'titulo') : ''; ?>

        <label for="descripcion">Descripcion</label>
        <textarea name="descripcion"><?= $entrada_actual['descripcion']; ?></textarea>
        <?php echo isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'descripcion') : ''; ?>

        <label for="categoria">Categoria</label>
        <select name="categoria">
            <?php $categorias = conseguirCategorias($db);
            if (!empty($categorias)) :
                while ($categoria = mysqli_fetch_assoc($categorias)) :
            ?>
                    <option value="<?= $categoria['id']; ?>" <?= ($categoria['id'] == $entrada_actual['categoria_id'] ? 'selected = "selected"' : '') ?>>
                        <?= $categoria['nombre']; ?>
                    </option>

            <?php
                endwhile;
            endif;
            ?>
        </select>
        <?php echo isset($_SESSION['errores_entrada']) ? mostrarError($_SESSION['errores_entrada'], 'categoria') : ''; ?>


        <input type="submit" value="Guardar">
    </form>
    <?php borrarErrores(); ?>
</main>











<?php require_once './includes/pie.php'; ?>
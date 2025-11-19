<?php
// Vista/producto/editarStock.php
require_once __DIR__ . '/../Estructura/header.php';
?>
<div class="container mt-4">
    <h2>Editar stock: <?= htmlspecialchars($producto->getProNombre()) ?></h2>
    <form method="post" action="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/guardarStock.php">
        <input type="hidden" name="idproducto" value="<?= htmlspecialchars($producto->getID()) ?>">
        <div class="mb-3">
            <label class="form-label">Stock actual</label>
            <input type="number" class="form-control" name="procantstock" value="<?= intval($producto->getProCantStock()) ?>" min="0">
        </div>
        <button class="btn btn-primary">Guardar</button>
        <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../Estructura/footer.php';

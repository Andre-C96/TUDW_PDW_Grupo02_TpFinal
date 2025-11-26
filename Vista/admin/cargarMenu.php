<?php
// Vista/admin/cargarMenu.php
require_once __DIR__ . '/../Estructura/header.php';
?>
<div class="container mt-4">
    <h2>Crear nuevo Menú</h2>

    <?php if (!empty($mensaje)) : ?>
        <div class="alert alert-<?= htmlspecialchars($tipoMensaje) ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="post" action="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Menu/cargar.php">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="menombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción (URL o ruta)</label>
            <input type="text" name="medescripcion" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Padre (opcional)</label>
            <select name="idpadre" class="form-select">
                <option value="">Ninguno</option>
                <?php foreach ($posiblesPadres as $pp) : ?>
                    <option value="<?= htmlspecialchars($pp->getID()) ?>"><?= htmlspecialchars($pp->getMeNombre()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-success" type="submit">Crear menú</button>
        <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Menu/listado.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

<?php require_once __DIR__ . '/../Estructura/footer.php';

<?php
// Vista/admin/listadoMenus.php
require_once __DIR__ . '/../Estructura/header.php';

?>
<div class="container mt-4">
    <h2>Administración de Menús</h2>

    <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Menu/cargar.php" class="btn btn-success mb-3">Crear nuevo menú</a>

    <?php if (!empty($menus)) : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción (URL)</th>
                    <th>Padre</th>
                        <th>Deshabilitado</th>
                        <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $m) : ?>
                    <tr>
                        <td><?= htmlspecialchars($m['idmenu']) ?></td>
                        <td><?= htmlspecialchars($m['menombre']) ?></td>
                        <td><?= htmlspecialchars($m['medescripcion']) ?></td>
                        <td><?= htmlspecialchars($m['idpadre'] ?? '-') ?></td>
                        <td><?= $m['medeshabilitado'] ? htmlspecialchars($m['medeshabilitado']) : 'Activo' ?></td>
                        <td>
                            <form method="post" action="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Menu/eliminar.php" style="display:inline;">
                                <input type="hidden" name="idmenu" value="<?= htmlspecialchars($m['idmenu']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este menú? Esta acción eliminará también las relaciones con roles.');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No hay menús cargados.</div>
    <?php endif; ?>

    <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/admin/panelAdmin.php" class="btn btn-secondary">Volver al panel</a>
</div>

<?php require_once __DIR__ . '/../Estructura/footer.php';

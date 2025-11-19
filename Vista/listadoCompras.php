<?php
// Vista/compra/listado.php
require_once __DIR__ . '/Estructura/header.php';

// $compras debe venir desde la acción; como fallback intentamos cargar vacío
if (!isset($compras)) {
    $compras = [];
}
?>
<div class="container mt-4">
    <h2>Listado de Compras</h2>
    <?php if (!empty($compras)) : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $c) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['idcompra']); ?></td>
                        <td><?php echo htmlspecialchars($c['cofecha']); ?></td>
                        <td><?php echo htmlspecialchars($c['usnombre'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($c['estado'] ?? ''); ?></td>
                        <td>
                            <?php if (isset($c['idcompra'])): ?>
                                <a href="/Vista/compra/ver.php?id=<?php echo urlencode($c['idcompra']); ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-info">No hay compras para mostrar.</div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../Estructura/footer.php'; ?>

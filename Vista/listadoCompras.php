
<?php
require_once __DIR__ . '/Estructura/header.php';
require_once __DIR__ . '/../Control/Session.php';
require_once __DIR__ . '/../Control/compraControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    echo '<div class="container mt-4"><div class="alert alert-warning">Debes iniciar sesión para ver tus compras.</div></div>';
    require_once __DIR__ . '/../Estructura/footer.php';
    exit;
}

$idUsuario = $session->getIDUsuarioLogueado();
$compraCtrl = new CompraControl();
$compras = $compraCtrl->listarCompras($idUsuario);

// Cancelar compra por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar_id']) && isset($_POST['cancelar_estado'])) {
    $idCompra = $_POST['cancelar_id'];
    $idCompraEstado = $_POST['cancelar_estado'];
    // Estado 4 = cancelada
    $compraCtrl->cancelarCompra([
        'idcompra' => $idCompra,
        'idcompraestado' => $idCompraEstado,
        'idcompraestadotipo' => 4
    ]);
    header('Location: listadoCompras.php');
    exit;
}
?>
<div class="container mt-4">
    <h2>Mis Compras</h2>
    <?php if (!empty($compras)) : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $c) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['idcompra']); ?></td>
                        <td><?php echo htmlspecialchars($c['cofecha']); ?></td>
                        <td><?php echo htmlspecialchars($c['estado'] ?? ''); ?></td>
                        <td>
                            <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/compra/ver.php?id=<?php echo urlencode($c['idcompra']); ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                            <?php if (strtolower($c['estado']) !== 'enviado' && strtolower($c['estado']) !== 'cancelada') : ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="cancelar_id" value="<?php echo htmlspecialchars($c['idcompra']); ?>">
                                    <input type="hidden" name="cancelar_estado" value="<?php echo htmlspecialchars($c['idcompraestado']); ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas cancelar esta compra?');">Cancelar</button>
                                </form>
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

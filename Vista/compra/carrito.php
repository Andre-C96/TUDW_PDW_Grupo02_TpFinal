<?php
// Vista/compra/carrito.php
if (!isset($productos)) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php');
    exit;
}
require_once __DIR__ . '/../Estructura/header.php';
?>
<div class="container mt-4">
    <h2>Mi carrito</h2>
    <?php if (count($productos) === 0): ?>
        <div class="alert alert-info">Tu carrito está vacío.</div>
        <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php" class="btn btn-primary">Seguir comprando</a>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; foreach ($productos as $p): ?>
                    <tr>
                        <td><img src="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/css/../img/<?= htmlspecialchars($p['imagen']) ?>" alt="" style="max-width:80px;"></td>
                        <td><?= htmlspecialchars($p['pronombre']) ?></td>
                        <td>$<?= number_format($p['precio'],2) ?></td>
                        <td><?= intval($p['cicantidad']) ?></td>
                        <td>$<?= number_format($p['subtotal'],2) ?></td>
                    </tr>
                <?php $total += $p['subtotal']; endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <div><strong>Total: $<?= number_format($total,2) ?></strong></div>
            <div>
                <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/vaciarCarrito.php" class="btn btn-danger">Vaciar carrito</a>
                <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/ejecutarCompraCarrito.php" class="btn btn-success">Finalizar compra</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../Estructura/footer.php';

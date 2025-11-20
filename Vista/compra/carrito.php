<?php
// Vista/compra/carrito.php

// Protección: Si no llega la variable, creamos un array vacío
if (!isset($productos)) {
    $productos = [];
}

require_once __DIR__ . '/../Estructura/header.php';
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center" style="color:var(--pine-green);">
        <img src="/TUDW_PDW_Grupo02_TpFinal/Util/Imagenes/IconShop.png" alt="icon" style="width:32px; vertical-align:bottom;"> 
        Tu Carrito
    </h2>

    <?php if (empty($productos)): ?>
        
        <div class="alert alert-info text-center p-5 shadow-sm">
            <h4>Tu carrito está vacío</h4>
            <p>¡Tenemos muchas cosas lindas esperando por ti!</p>
            <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php" class="btn btn-success mt-3">Ir a la Tienda</a>
        </div>

    <?php else: ?>
        <div class="card shadow">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Producto</th>
                                <th>Precio</th>
                                <th class="text-center">Cantidad</th>
                                <th>Subtotal</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalGeneral = 0;
                            foreach ($productos as $p): 
                                // --- CÁLCULOS ---
                                // USAMOS 'precio' COMO ME INDICASTE
                                $precio = floatval($p['precio'] ?? 0); 
                                $cantidad = intval($p['cicantidad']);
                                $subtotal = $precio * $cantidad;
                                $totalGeneral += $subtotal;

                                // USAMOS 'proimagen' COMO ME INDICASTE
                                $imgNombre = $p['proimagen'] ?? 'sin_imagen.png';
                                // Ruta de la imagen (Asegúrate que estén en esta carpeta)
                                $rutaImagen = "/TUDW_PDW_Grupo02_TpFinal/Util/Imagenes/" . $imgNombre;
                            ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= htmlspecialchars($rutaImagen) ?>" 
                                                 alt="Img" 
                                                 class="rounded border bg-white"
                                                 style="width: 60px; height: 60px; object-fit: contain; margin-right: 15px;"
                                                 onerror="this.src='/TUDW_PDW_Grupo02_TpFinal/Util/Imagenes/sin_imagen.png'">
                                            
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($p['pronombre']) ?></h6>
                                                <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                                    <?= htmlspecialchars($p['prodetalle']) ?>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>$<?= number_format($precio, 2, ',', '.') ?></td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-3 py-2">
                                            <?= $cantidad ?>
                                        </span>
                                    </td>

                                    <td class="fw-bold text-success">
                                        $<?= number_format($subtotal, 2, ',', '.') ?>
                                    </td>

                                    <td class="text-end pe-4">
                                        <form action="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/eliminarItem.php" method="post">
                                            <input type="hidden" name="idcompraitem" value="<?= $p['idcompraitem'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Quitar producto" onclick="return confirm('¿Quitar este producto?');">
                                                &times;
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/vaciarCarrito.php" 
                           class="btn btn-outline-secondary text-danger border-danger btn-sm" 
                           onclick="return confirm('¿Estás seguro de vaciar todo el carrito?');">
                           Vaciar Carrito
                        </a>
                    </div>
                    <div class="col-md-6 text-end">
                        <h4 class="d-inline-block me-3 align-middle mb-0">
                            Total: <span class="text-success fw-bold">$<?= number_format($totalGeneral, 2, ',', '.') ?></span>
                        </h4>
                        <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/finalizarCompra.php" 
                           class="btn btn-success btn-lg shadow-sm ms-2">
                           Finalizar Compra
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../Estructura/footer.php'; ?>
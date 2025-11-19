<?php
// Vista/index.php - página de inicio con listado de productos tipo tienda
require_once __DIR__ . '/../Control/productoControl.php';
require_once __DIR__ . '/../Control/menuControl.php';
require_once __DIR__ . '/../Control/Session.php';

$prodCtrl = new ProductoControl();
$menuCtrl = new MenuControl();
$session = new Session();

$menuData = $menuCtrl->armarMenu();
$productos = $prodCtrl->listarProdTienda();

require_once __DIR__ . '/Estructura/header.php';
?>
<div class="container mt-4">
    <h1>Tienda</h1>
    <div class="row">
        <?php foreach ($productos as $p): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/css/../img/<?= htmlspecialchars($p['imagen']) ?>" class="card-img-top" style="object-fit:cover; height:200px;" alt="">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($p['pronombre']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($p['prodetalle']) ?></p>
                        <div class="mt-auto">
                            <p class="fw-bold">$<?= number_format($p['precio'],2) ?></p>
                            <?php if ($session->sesionActiva()): ?>
                                <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/agregarProdCarrito.php?idproducto=<?= $p['idproducto'] ?>" class="btn btn-primary">Agregar al carrito</a>
                            <?php else: ?>
                                <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/login.php" class="btn btn-outline-primary">Iniciar sesión para comprar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/Estructura/footer.php';

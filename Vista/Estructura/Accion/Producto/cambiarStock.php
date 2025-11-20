<?php
// Vista/Estructura/Accion/Producto/cambiarStock.php
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/productoControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

$rol = $session->getRolActivo();
$isAdmin = (!empty($rol) && isset($rol['rol']) && strtolower($rol['rol']) === 'administrador');
if (!$isAdmin) {
    echo '<div class="container mt-4"><div class="alert alert-danger">Acceso denegado. Debés ser administrador.</div></div>';
    require_once __DIR__ . '/../../../../Vista/Estructura/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/listadoProductos.php');
    exit;
}

$idproducto = isset($_POST['idproducto']) ? intval($_POST['idproducto']) : null;
$procantstock = isset($_POST['procantstock']) ? intval($_POST['procantstock']) : null;

$productoCtrl = new ProductoControl();
if ($idproducto === null || $procantstock === null) {
    // Redirect back with error (simple)
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/listadoProductos.php');
    exit;
}

$result = $productoCtrl->modificarStock(['idproducto' => $idproducto, 'procantstock' => $procantstock]);

// Redirect back to product list (could add flash messages later)
header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php');
exit;

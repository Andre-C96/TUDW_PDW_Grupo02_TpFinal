<?php
// Vista/Estructura/Accion/Compra/eliminarItem.php

$root = __DIR__ . '/../../../../';

require_once $root . 'Control/Session.php';
require_once $root . 'Control/compraItemControl.php';
require_once $root . 'Control/usuarioControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php');
    exit;
}

$idCompItem = isset($_POST['idcompraitem']) ? intval($_POST['idcompraitem']) : null;
if (empty($idCompItem)) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php');
    exit;
}

$compraItemCtrl = new CompraItemControl();
$items = $compraItemCtrl->buscar(['idcompraitem' => $idCompItem]);
if (empty($items)) {
    // Item no encontrado
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php');
    exit;
}

$item = $items[0];
$idCompraDelItem = $item->getObjCompra()->getID();

// Verificar que el carrito pertenece al usuario logueado
$idUsuario = $session->getIDUsuarioLogueado();
$usuarioCtrl = new UsuarioControl();
$carrito = $usuarioCtrl->obtenerCarrito($idUsuario);

if ($carrito == null || $carrito->getID() != $idCompraDelItem) {
    // Intento de eliminar item que no pertenece al carrito del usuario
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php');
    exit;
}

$ok = $compraItemCtrl->baja(['idcompraitem' => $idCompItem]);
if ($ok) {
    $_SESSION['flash'] = 'Producto eliminado del carrito.';
} else {
    $_SESSION['flash'] = 'No se pudo eliminar el producto.';
}

header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php');
exit;

?>


<?php
// accion/compra/ejecutarCompraCarrito.php
// Acción que finaliza la compra del carrito del usuario logueado

require_once __DIR__ . '/../../../Control/Session.php';
require_once __DIR__ . '/../../../Control/compraControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    header('Location: /Vista/login.php');
    exit;
}

$compraCtrl = new CompraControl();
$result = $compraCtrl->ejecutarCompraCarrito();

// $result expected: ['idcompra' => int, 'respuesta' => bool]
if (is_array($result) && isset($result['respuesta']) && $result['respuesta']) {
    $id = $result['idcompra'] ?? '';
    header('Location: /Vista/compra/confirmacion.php?id=' . urlencode($id));
    exit;
} else {
    header('Location: /Vista/compra/listado.php?error=1');
    exit;
}

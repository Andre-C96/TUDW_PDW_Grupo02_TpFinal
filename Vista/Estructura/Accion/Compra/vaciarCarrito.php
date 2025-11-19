<?php
// accion/compra/vaciarCarrito.php
// Acción que vacía el carrito del usuario logueado

require_once __DIR__ . '/../../../Control/Session.php';
require_once __DIR__ . '/../../../Control/compraControl.php';
require_once __DIR__ . '/../../../Control/usuarioControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

$idUser = $session->getIDUsuarioLogueado();
$usuarioCtrl = new UsuarioControl();
$carrito = $usuarioCtrl->obtenerCarrito($idUser);
$resp = false;
if ($carrito) {
    $compraCtrl = new CompraControl();
    $resp = $compraCtrl->vaciarCarrito($carrito->getID());
}

if ($resp) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/listado.php?msg=vaciar_ok');
    exit;
} else {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/listado.php?error=vaciar');
    exit;
}

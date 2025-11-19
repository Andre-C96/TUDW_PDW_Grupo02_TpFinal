<?php
// Vista/Estructura/Accion/Compra/mostrarCarrito.php
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/compraControl.php';
require_once __DIR__ . '/../../../../Control/usuarioControl.php';
require_once __DIR__ . '/../../../../Control/menuControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

$compraCtrl = new CompraControl();
$usuarioCtrl = new UsuarioControl();
$menuCtrl = new MenuControl();
$menuData = $menuCtrl->armarMenu();

$idUser = $session->getIDUsuarioLogueado();
$carrito = $usuarioCtrl->obtenerCarrito($idUser);
$productos = $compraCtrl->listadoProdCarrito($carrito);

require_once __DIR__ . '/../../../../Vista/compra/carrito.php';

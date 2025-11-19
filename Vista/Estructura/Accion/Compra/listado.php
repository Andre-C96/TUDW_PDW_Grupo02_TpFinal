<?php
// Vista/Estructura/Accion/Compra/listado.php
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/compraControl.php';
require_once __DIR__ . '/../../../../Control/menuControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

$compraCtrl = new CompraControl();
$menuCtrl = new MenuControl();
$menuData = $menuCtrl->armarMenu();

$rolActivo = $session->getRolActivo();
if (!empty($rolActivo) && isset($rolActivo['rol']) && strtolower($rolActivo['rol']) === 'administrador') {
    $compras = $compraCtrl->listarComprasUsuarios();
} else {
    $idUser = $session->getIDUsuarioLogueado();
    $compras = $compraCtrl->listarCompras($idUser);
}

require_once __DIR__ . '/../../../../Vista/listadoCompras.php';

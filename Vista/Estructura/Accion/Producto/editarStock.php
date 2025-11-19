<?php
// Vista/Estructura/Accion/Producto/editarStock.php
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/productoControl.php';
require_once __DIR__ . '/../../../../Control/menuControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

$rolActivo = $session->getRolActivo();
$rol = '';
if (!empty($rolActivo) && isset($rolActivo['rol'])) {
    $rol = strtolower($rolActivo['rol']);
}

if (!in_array($rol, ['deposito','depositista'])) {
    $_SESSION['flash'] = 'No autorizado.';
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/index.php');
    exit;
}

if (!isset($_GET['idproducto'])) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php');
    exit;
}

$prodCtrl = new ProductoControl();
$menuCtrl = new MenuControl();
$menuData = $menuCtrl->armarMenu();

$list = $prodCtrl->buscar(['idproducto' => $_GET['idproducto']]);
if (count($list) === 0) {
    $_SESSION['flash'] = 'Producto no encontrado.';
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php');
    exit;
}
$producto = $list[0];

require_once __DIR__ . '/../../../../Vista/producto/editarStock.php';

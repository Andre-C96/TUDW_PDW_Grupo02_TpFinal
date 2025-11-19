<?php
// Vista/Estructura/Accion/Producto/guardarStock.php
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/productoControl.php';

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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php');
    exit;
}

$idproducto = isset($_POST['idproducto']) ? intval($_POST['idproducto']) : null;
$procantstock = isset($_POST['procantstock']) ? intval($_POST['procantstock']) : null;

if ($idproducto === null || $procantstock === null) {
    $_SESSION['flash'] = 'Datos inválidos.';
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php');
    exit;
}

$prodCtrl = new ProductoControl();
$ok = $prodCtrl->modificarStock(['idproducto' => $idproducto, 'procantstock' => $procantstock]);
if ($ok) {
    $_SESSION['flash'] = 'Stock actualizado.';
} else {
    $_SESSION['flash'] = 'No se pudo actualizar el stock.';
}

header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php');
exit;

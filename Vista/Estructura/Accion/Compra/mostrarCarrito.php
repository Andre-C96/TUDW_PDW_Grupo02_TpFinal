<?php
// Vista/Estructura/Accion/Compra/mostrarCarrito.php
// ACCIÓN MINIMALISTA

// 1. RUTAS
$root = __DIR__ . '/../../../../';
require_once $root . 'Control/Session.php';
require_once $root . 'Control/compraControl.php';
require_once $root . 'Control/menuControl.php';
require_once $root . 'Control/usuarioControl.php'; // Necesario por dependencias internas

$session = new Session();
if (!$session->activa()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// 2. RECUPERAR DATOS
$idUser = $session->getIDUsuarioLogueado();

// 3. INVOCAR CONTROLADORES
// A) Productos del carrito
$compraCtrl = new CompraControl();
$productos = $compraCtrl->obtenerProductosDelCarrito($idUser);

// B) Menú dinámico (para el header)
$menuCtrl = new MenuControl();
$menuData = $menuCtrl->armarMenu();

// 4. CARGAR VISTA
require_once __DIR__ . '/../../../../Vista/compra/carrito.php';
?>


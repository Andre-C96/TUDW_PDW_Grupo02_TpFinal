<?php
// Vista/Estructura/Accion/Venta/listado.php
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/compraControl.php';
require_once __DIR__ . '/../../../../Control/menuControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
	header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
	exit;
}

$rolActivo = $session->getRolActivo();
if (empty($rolActivo) || !isset($rolActivo['rol']) || strtolower($rolActivo['rol']) !== 'administrador') {
	echo '<div class="container mt-4"><div class="alert alert-danger">Acceso denegado. Debés ser administrador.</div></div>';
	require_once __DIR__ . '/../../../../Vista/Estructura/footer.php';
	exit;
}

$compraCtrl = new CompraControl();
$menuCtrl = new MenuControl();
$menuData = $menuCtrl->armarMenu();

// Obtener todas las compras con su último estado
$compras = $compraCtrl->listarComprasUsuarios();

// Reusar la vista existente de listado de compras
require_once __DIR__ . '/../../../../Vista/listadoCompras.php';


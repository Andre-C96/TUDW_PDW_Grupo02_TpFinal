<?php
// Vista/Estructura/header.php
// Header común con Bootstrap navbar — ahora usa MenuControl para armar menú por rol
require_once __DIR__ . '/../../Control/Session.php';
require_once __DIR__ . '/../../Control/menuControl.php';

$sesion = new Session();
$menuControl = new MenuControl();
$menuData = $menuControl->armarMenu();
$rol = '';
if (!empty($menuData) && isset($menuData['usuario']['rol'])) {
	$rol = strtoupper($menuData['usuario']['rol']);
}
?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ChrismasMarket</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/Vista/Estructura/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
	<a class="navbar-brand" href="/Vista/index.php">ChrismasMarket</a>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	  <span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNav">
	  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		<li class="nav-item"><a class="nav-link" href="/Vista/producto/listado.php">Productos</a></li>
		<?php if ($rol !== 'CLIENTE'): ?>
			<li class="nav-item"><a class="nav-link" href="/Vista/producto/abm.php">Gestionar Productos</a></li>
		<?php endif; ?>
		<?php if ($rol === 'ADMINISTRADOR'): ?>
			<li class="nav-item"><a class="nav-link" href="/Vista/rol/abm.php">Roles</a></li>
			<li class="nav-item"><a class="nav-link" href="/Vista/menu/abm.php">Menu</a></li>
		<?php endif; ?>
		<?php if ($rol === 'DEPOSITO' || $rol === 'ADMINISTRADOR'): ?>
			<li class="nav-item"><a class="nav-link" href="/Vista/producto/stock.php">Ajuste de Stock</a></li>
		<?php endif; ?>
		<li class="nav-item"><a class="nav-link" href="/Vista/compra/listado.php">Mis Compras</a></li>
	  </ul>
	  <ul class="navbar-nav">
		<?php if ($sesion->sesionActiva()): ?>
			<li class="nav-item"><a class="nav-link" href="/Vista/perfil.php"><?php echo htmlspecialchars($menuData['usuario']['nombre'] ?? 'Usuario'); ?></a></li>
			<li class="nav-item"><a class="nav-link" href="/accion/login/logout.php">Cerrar sesión</a></li>
		<?php else: ?>
			<li class="nav-item"><a class="nav-link" href="/Vista/login.php">Login</a></li>
		<?php endif; ?>
	  </ul>
	</div>
  </div>
</nav>


<?php
// Vista/Estructura/Accion/Producto/listado.php
require_once __DIR__ . '/../../../../Control/productoControl.php';
require_once __DIR__ . '/../../../../Control/menuControl.php';

$prodCtrl = new ProductoControl();
$productos = $prodCtrl->buscar([]);

$menuCtrl = new MenuControl();
$menuData = $menuCtrl->armarMenu();

// Render view
require_once __DIR__ . '/../../../../Vista/listadoProductos.php';

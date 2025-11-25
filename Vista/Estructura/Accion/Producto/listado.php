<?php
// Vista/Estructura/Accion/Producto/listado.php


//  RUTAS
$root = __DIR__ . '/../../../../';
require_once $root . 'Control/Session.php';
require_once $root . 'Control/productoControl.php';
require_once $root . 'Control/menuControl.php';

// SESIÓN 
$session = new Session();

// INVOCAR CONTROLADORES
$prodCtrl = new ProductoControl();

// Buscamos todos los productos 
$productos = $prodCtrl->buscar([]); 

// Armado de Menú Dinámico
$menuCtrl = new MenuControl();
$menuData = $menuCtrl->armarMenu();

// CARGAR VISTA
// Ruta correcta a la vista que contiene el HTML
require_once __DIR__ . '/../../../../Vista/listadoProductos.php';
?>
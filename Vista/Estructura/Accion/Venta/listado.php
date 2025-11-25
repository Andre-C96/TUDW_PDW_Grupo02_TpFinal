<?php
// Vista/Estructura/Accion/Venta/listado.php
// ACCIÓN MINIMALISTA: Panel de Ventas (Admin)

// 1. RUTAS
$root = __DIR__ . '/../../../../';
require_once $root . 'Control/Session.php';
require_once $root . 'Control/compraControl.php';
require_once $root . 'Control/menuControl.php'; // Si usas menú dinámico

$session = new Session();

// 2. SEGURIDAD (Login + Rol Admin)
$rol = $session->getRolActivo();
if (!$session->activa() || empty($rol) || ($rol['id'] != 1 && strtolower($rol['rol']) !== 'administrador')) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php?msg=acceso_denegado');
    exit;
}

// 3. INVOCAR CONTROLADOR
$compraCtrl = new CompraControl();

// Toda la lógica de bucles y estados se mudó al controlador
$compras = $compraCtrl->obtenerListadoDeVentas(); 

// (Opcional) Menú
$menuCtrl = new MenuControl();
$menuData = $menuCtrl->armarMenu();

// 4. CARGAR VISTA
// Intentamos cargar una vista específica de ventas, sino usamos la genérica
$vistaVentas = $root . 'Vista/venta/listado.php'; // Asegúrate de crear esta carpeta si no existe
$vistaGenerica = $root . 'Vista/compra/listadoCompras.php';

if (file_exists($vistaVentas)) {
    require_once $vistaVentas;
} else {
    // Reutilizamos la vista de historial de compras (que ya acepta el array $compras)
    require_once $vistaGenerica;
}
?>

<?php
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

// Armamos el menú
$menuData = $menuCtrl->armarMenu();

$idUser = $session->getIDUsuarioLogueado();
$carrito = $usuarioCtrl->obtenerCarrito($idUser);

// Inicializamos productos como array vacío por defecto
$productos = [];

if ($carrito) {
    // Solo buscamos productos si existe el carrito
    $resultado = $compraCtrl->listadoProdCarrito($carrito);
    if ($resultado) {
        $productos = $resultado;
    }
}

// Incluimos la vista. Ajustamos la ruta para estar seguros (4 atrás llega a la raíz)
require_once __DIR__ . '/../../../../Vista/compra/carrito.php';
?>
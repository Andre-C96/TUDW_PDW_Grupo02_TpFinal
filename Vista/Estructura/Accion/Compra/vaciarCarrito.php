<?php
// Vista/Estructura/Accion/Compra/vaciarCarrito.php
// ACCIÓN MINIMALISTA

// 1. RUTAS
$root = __DIR__ . '/../../../../';
require_once $root . 'Control/Session.php';
require_once $root . 'Control/compraControl.php';
require_once $root . 'Control/usuarioControl.php'; // Necesario para dependencias internas

$session = new Session();

// 2. VALIDACIÓN SESIÓN
if (!$session->activa()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// 3. OBTENER DATOS
// Simplificamos la obtención del ID
if (method_exists($session, 'getIDUsuarioLogueado')) {
    $idUsuario = $session->getIDUsuarioLogueado();
} else {
    $idUsuario = $_SESSION['idusuario'] ?? null;
}

// 4. INVOCAR CONTROLADOR
$compraCtrl = new CompraControl();
$resultado = false;

if ($idUsuario) {
    // Delegamos toda la tarea al controlador
    $resultado = $compraCtrl->vaciarCarritoDeUsuario($idUsuario);
}

// 5. REDIRECCIÓN
if ($resultado) {
    // Éxito: Se vaciaron los items
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php?msg=carrito_vaciado");
} else {
    // Fallo: Estaba vacío o no se encontró (igual mostramos el carrito)
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php");
}
exit;
?>
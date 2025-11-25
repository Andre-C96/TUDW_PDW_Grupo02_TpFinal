<?php
// Vista/Estructura/Accion/Producto/cargarNuevoProducto.php

// RUTAS Y CONFIGURACIÓN
$root = __DIR__ . '/../../../../';
require_once $root . 'Control/Session.php';
require_once $root . 'Control/productoControl.php';
require_once $root . 'config.php';



if (file_exists($root . 'config.php')) {
    require_once $root . 'config.php';
}

$session = new Session();

// SEGURIDAD 
$rol = $session->getRolActivo();
if (!$session->activa() || empty($rol) || ($rol['id'] != 1 && strtolower($rol['rol']) !== 'administrador')) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php?msg=acceso_denegado');
    exit;
}

// RECOLECCIÓN DE DATOS
$datos = $_POST;
if (isset($_FILES['proimagen'])) {
    $datos['proimagen'] = $_FILES['proimagen'];
}

// INVOCAR CONTROLADOR
$prodCtrl = new ProductoControl();
$resp = $prodCtrl->crearProductoConImagen($datos);

// REDIRECCIÓN
$msg = urlencode($resp['mensaje']);
$rutaAdmin = '/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php'; 

if ($resp['exito']) {
    header("Location: $rutaAdmin?msg=producto_creado&info=$msg");
} else {
    header("Location: $rutaAdmin?msg=error_creacion&info=$msg");
}
exit;
?>
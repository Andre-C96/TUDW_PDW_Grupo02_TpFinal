<?php
// Vista/Estructura/Accion/Compra/cambiarEstado.php

// 1. RUTAS Y CONFIGURACIÓN

require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/compraControl.php';

$session = new Session();

// VALIDAR SESIÓN
if (!$session->activa()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// SEGURIDAD: SOLO ADMIN
// Verificamos si el rol activo es Administrador
$rolActivo = $session->getRolActivo();
$esAdmin = false;

if (!empty($rolActivo)) {
    // Ajusta esto si tu rol admin tiene otro ID o Nombre
    if ($rolActivo['id'] == 1 || $rolActivo['rol'] == 'Administrador') {
        $esAdmin = true;
    }
}

if (!$esAdmin) {
    // Si un cliente intenta entrar aquí, lo expulsamos
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=acceso_denegado');
    exit;
}

// RECIBIR DATOS
// Usamos $_POST directo para asegurar compatibilidad
$idCompra = $_POST['idcompra'] ?? null;
$nuevoEstado = $_POST['nuevoEstado'] ?? null;

// EJECUTAR EL CAMBIO
if ($idCompra && $nuevoEstado) {
    $compraCtrl = new CompraControl();
    
    // Llamamos a la función "Jefa" del controlador
    if ($compraCtrl->actualizarEstadoCompra($idCompra, $nuevoEstado)) {
        // Volvemos a ver la compra actualizada
        header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/verCompra.php?id=$idCompra&msg=estado_actualizado");
    } else {
        // Fallo en BD
        header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/verCompra.php?id=$idCompra&msg=error_bd");
    }
} else {
    // Datos incompletos
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=datos_incompletos");
}
exit;
?>
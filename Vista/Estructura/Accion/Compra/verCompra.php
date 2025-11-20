<?php
// Vista/Estructura/Accion/Compra/verCompra.php


require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/compraControl.php';
require_once __DIR__ . '/../../../../Control/compraEstadoControl.php';
require_once __DIR__ . '/../../../../Control/usuarioControl.php';

$session = new Session();
if (!$session->activa()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

$idUsuarioLogueado = $session->getIDUsuarioLogueado() ?? $_SESSION['idusuario'];
$idCompra = $_GET['id'] ?? null;

if (!$idCompra) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=error_id');
    exit;
}

// BUSCAR LA COMPRA
$compraCtrl = new CompraControl();
$listaCompras = $compraCtrl->buscar(['idcompra' => $idCompra]);

if (empty($listaCompras)) {
    die("La compra no existe.");
}

$objCompra = $listaCompras[0];

$rolActivo = $session->getRolActivo();
$esAdmin = false;

// Verificamos si el rol es 'Administrador' 
if (!empty($rolActivo)) {
    // Ajusta 'Administrador' si en tu base de datos se llama distinto (ej: 'Admin')
    if ($rolActivo['rol'] == 'Administrador' || $rolActivo['id'] == 1) {
        $esAdmin = true;
    }
}

// Verificar ser admin o dueño de la compra
if ($objCompra->getObjUsuario()->getID() != $idUsuarioLogueado && !$esAdmin) {
    
    die("<div class='alert alert-danger text-center mt-5'><h1>Acceso Denegado</h1><p>Esta compra no te pertenece.</p></div>");
}

// OBTENER ESTADO ACTUAL
$estadoCtrl = new CompraEstadoControl();
$estados = $estadoCtrl->buscar(['idcompra' => $idCompra]);
$ultimoEstado = null;
$historialEstados = [];

if (!empty($estados)) {
    $ultimoEstado = end($estados); 
    $historialEstados = $estados; 
}

//. OBTENER PRODUCTOS 
$productos = $compraCtrl->listadoProdCarrito($objCompra);

// 5. CARGAR VISTA
require_once __DIR__ . '/../../../compra/detalleCompra.php';
?>
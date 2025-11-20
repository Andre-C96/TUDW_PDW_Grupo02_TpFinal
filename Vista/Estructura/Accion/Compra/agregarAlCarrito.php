<?php
// Vista/Estructura/Accion/Compra/agregarAlCarrito.php

// 1. CONFIGURACIÓN DE RUTAS
// Definimos la raíz del proyecto subiendo 4 niveles desde este archivo
$root = __DIR__ . '/../../../../';

require_once $root . 'Control/Session.php';
require_once $root . 'Control/compraControl.php';
require_once $root . 'Control/compraEstadoControl.php';
require_once $root . 'Control/productoControl.php';

// Detectar si el control de items se llama CompraItemControl o CompraProductoControl
if (file_exists($root . 'Control/compraItemControl.php')) {
    require_once $root . 'Control/compraItemControl.php';
    $claseItem = 'CompraItemControl';
} elseif (file_exists($root . 'Control/compraProductoControl.php')) {
    require_once $root . 'Control/compraProductoControl.php';
    $claseItem = 'CompraProductoControl';
} else {
    // Por defecto probamos CompraItemControl
    require_once $root . 'Control/compraItemControl.php';
    $claseItem = 'CompraItemControl';
}

$session = new Session();

// 2. VALIDAR SESIÓN
if (!$session->activa()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// 3. OBTENER DATOS (Usuario y Producto)
// Intentamos obtener el ID del usuario con los métodos estándar
if (method_exists($session, 'getIDUsuarioLogueado')) {
    $idUsuario = $session->getIDUsuarioLogueado();
} else {
    $idUsuario = $session->getIdUsuario();
}

// Recibimos el ID del producto (GET o POST)
$idProducto = $_GET['idProducto'] ?? ($_POST['idProducto'] ?? null);

if (!$idProducto) {
    // Si no llega el ID, volvemos a la tienda con error
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=no_id_producto');
    exit;
}

// 4. INICIALIZAR CONTROLADORES
$abmCompra = new CompraControl();
$abmCompraEstado = new CompraEstadoControl();
$abmItem = new $claseItem(); // Instancia dinámica del control de items

// 5. BUSCAR CARRITO ACTIVO (Compra con estado "iniciada")
$comprasUsuario = $abmCompra->buscar(['idusuario' => $idUsuario]);
$idCompraActiva = null;

if (!empty($comprasUsuario)) {
    // Recorremos las compras para ver cuál está activa
    foreach ($comprasUsuario as $compra) {
        $estados = $abmCompraEstado->buscar(['idcompra' => $compra->getId()]);
        
        if (!empty($estados)) {
            // Obtenemos el último estado de esta compra
            $ultimoEstado = end($estados);
            
            // CORRECCIÓN CLAVE AQUÍ:
            // Usamos getObj... para traer el objeto tipo
            // Usamos getID() con mayúscula como está en tu clase
            // Verificamos que sea tipo 1 (iniciada) y fecha fin nula (actual)
            if ($ultimoEstado->getObjCompraEstadoTipo()->getID() == 1 && $ultimoEstado->getCeFechaFin() == null) {
                $idCompraActiva = $compra->getId();
                break; 
            }
        }
    }
}

// 6. SI NO HAY CARRITO, CREAR UNO NUEVO
if ($idCompraActiva == null) {
    // Crear la compra (cabecera)
    if ($abmCompra->alta(['idusuario' => $idUsuario])) {
        // Recuperamos el ID de la compra recién creada
        $compras = $abmCompra->buscar(['idusuario' => $idUsuario]);
        $ultimaCompra = end($compras);
        $idCompraActiva = $ultimaCompra->getId();
        
        // Asignar el estado inicial (1 = iniciada)
        $abmCompraEstado->alta([
            'idcompra' => $idCompraActiva, 
            'idcompraestadotipo' => 1
        ]);
    } else {
        header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=error_crear_compra');
        exit;
    }
}

// 7. GESTIONAR EL ITEM (Agregar nuevo o sumar cantidad)
$itemsEnCarrito = $abmItem->buscar([
    'idcompra' => $idCompraActiva,
    'idproducto' => $idProducto
]);

$exito = false;

if (!empty($itemsEnCarrito)) {
    // CASO A: El producto YA está en el carrito -> Sumamos +1 a la cantidad
    $itemExistente = $itemsEnCarrito[0];
    $nuevaCantidad = $itemExistente->getCiCantidad() + 1;
    
    $param = [
        'idcompraitem' => $itemExistente->getId(),
        'idcompra'     => $idCompraActiva,
        'idproducto'   => $idProducto,
        'cicantidad'   => $nuevaCantidad
    ];
    $exito = $abmItem->modificacion($param);

} else {
    // CASO B: El producto NO está en el carrito -> Lo creamos con cantidad 1
    $param = [
        'idcompra'   => $idCompraActiva,
        'idproducto' => $idProducto,
        'cicantidad' => 1
    ];
    $exito = $abmItem->alta($param);
}

// 8. REDIRECCIÓN FINAL
if ($exito) {
    // Éxito: Vamos a ver el carrito
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php");
} else {
    // Fallo: Volvemos al listado
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=error_al_agregar");
}
exit;
?>
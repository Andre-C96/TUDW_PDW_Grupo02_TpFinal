<?php
// Asegúrate de que estos archivos existan y se llamen EXACTAMENTE así en tu carpeta Control
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/compraControl.php';
require_once __DIR__ . '/../../../../Control/compraEstadoControl.php';
require_once __DIR__ . '/../../../../Control/productoControl.php'; 

// OJO: Verifica si tu archivo se llama 'compraItemControl.php' o 'compraProductoControl.php'
// La clase dentro debe coincidir con el new ...() de abajo.
// Asumo que es compraItemControl por la lógica de la DB.
if (file_exists(__DIR__ . '/../../../../Control/compraItemControl.php')) {
    require_once __DIR__ . '/../../../../Control/compraItemControl.php';
} else {
    require_once __DIR__ . '/../../../../Control/compraProductoControl.php';
}

$session = new Session();

// 1. Validar sesión activa
if (!$session->activa()) {
    // CORRECCIÓN RUTA: Ajusta "TUDW_PDW_Grupo02_TpFinal" si tu carpeta se llama distinto
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// 2. CORRECCIÓN: El método correcto según tu Session.php
$idUsuario = $session->getIDUsuarioLogueado(); 
$idProducto = $_GET['idProducto'] ?? null;

if (!$idProducto) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php');
    exit;
}

$abmCompra = new CompraControl();
$abmCompraEstado = new CompraEstadoControl();

// Buscar compras del usuario
$comprasUsuario = $abmCompra->buscar(['idusuario' => $idUsuario]); // Ojo: idusuario suele ser minúscula en la BD/PDO
$idCompraActiva = null;

// Lógica para buscar carrito activo (estado 1: iniciada)
if (!empty($comprasUsuario)) {
    // Recorremos buscando una que tenga estado 'iniciada' (1) y fecha fin null
    foreach ($comprasUsuario as $compra) {
        // Buscamos el estado más reciente de esa compra
        $listaEstados = $abmCompraEstado->buscar(['idcompra' => $compra->getId()]);
        
        if (!empty($listaEstados)) {
            // Obtenemos el último estado (asumiendo que buscar devuelve ordenado o el ultimo array es el actual)
            $ultimoEstado = end($listaEstados);
            
            // Si el estado es 1 (iniciada) y fecha fin es null (es el actual)
            if ($ultimoEstado->getCompraEstadoTipo()->getId() == 1 && $ultimoEstado->getCeFechaFin() == null) {
                $idCompraActiva = $compra->getId();
                break;
            }
        }
    }
}

// Si no hay carrito activo, crear uno nuevo
if ($idCompraActiva == null) {
    // Crear compra
    if ($abmCompra->alta(['idusuario' => $idUsuario])) {
        // Obtener el ID de la compra recién creada
        $compras = $abmCompra->buscar(['idusuario' => $idUsuario]);
        $ultimaCompra = end($compras);
        $idCompraActiva = $ultimaCompra->getId();
        
        // Ponerle estado "iniciada" (1)
        $abmCompraEstado->alta(['idcompra' => $idCompraActiva, 'idcompraestadotipo' => 1]);
    } else {
        header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/index.php?msg=error_crear_compra');
        exit;
    }
}

// Instanciar controles de items

$abmCompraItem = new CompraItemControl(); 
$abmProducto = new ProductoControl();

// Verificar si el producto ya está en el carrito
$itemsEnCarrito = $abmCompraItem->buscar([
    'idcompra' => $idCompraActiva,
    'idproducto' => $idProducto
]);

$exito = false;

// Verificar Stock del producto
$listaProductos = $abmProducto->buscar(['idproducto' => $idProducto]);
if (empty($listaProductos)) {
     header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/index.php?msg=producto_no_existe");
     exit;
}
$prodObj = $listaProductos[0];


if ($prodObj->getProCantStock() >= 1) { // Usar getProCantStock() según tu tabla

    if (!empty($itemsEnCarrito)) {
        // El producto YA está en el carrito: Sumar cantidad
        $itemExistente = $itemsEnCarrito[0];
        $nuevaCantidad = $itemExistente->getCiCantidad() + 1; // Usar getCiCantidad()
        
        $param = [
            'idcompraitem' => $itemExistente->getId(),
            'idcompra' => $idCompraActiva,
            'idproducto' => $idProducto,
            'cicantidad' => $nuevaCantidad
        ];
        $exito = $abmCompraItem->modificacion($param);

    } else {
        // El producto NO está: Crear item nuevo
        $param = [
            'idcompra' => $idCompraActiva,
            'idproducto' => $idProducto,
            'cicantidad' => 1
        ];
        $exito = $abmCompraItem->alta($param);
    }
    
    
} else {
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php?msg=sin_stock");
    exit;
}

if ($exito) {
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php");
} else {
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/index.php?msg=error_agregar");
}
exit;
?>
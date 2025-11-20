<?php


// RUTAS
$root = __DIR__ . '/../../../../';
require_once $root . 'Control/Session.php';
require_once $root . 'Control/compraControl.php';
require_once $root . 'Control/productoControl.php';
require_once $root . 'Control/usuarioControl.php';

// Aseguramos carga de Composer por si el controlador lo necesita para Carbon/Email
if (file_exists($root . 'vendor/autoload.php')) {
    require_once $root . 'vendor/autoload.php';
}

// SESIÓN
$session = new Session();
if (!$session->activa()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// Obtener ID Usuario
if (method_exists($session, 'getIDUsuarioLogueado')) {
    $idUsuario = $session->getIDUsuarioLogueado();
} else {
    $idUsuario = $_SESSION['idusuario'] ?? null;
}

// BUSCAR EL CARRITO
$uControl = new UsuarioControl();
$carrito = $uControl->obtenerCarrito($idUsuario);

if ($carrito == null) {
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=carrito_vacio_error");
    exit;
}

// OBTENER PRODUCTOS
$compraCtrl = new CompraControl();
$productos = $compraCtrl->listadoProdCarrito($carrito);

if (empty($productos)) {
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=carrito_vacio");
    exit;
}

// VALIDAR STOCK (Paso preventivo)
$prodCtrl = new ProductoControl();
$stockOk = true;
$msgError = "";

foreach ($productos as $item) {
    $listaP = $prodCtrl->buscar(['idproducto' => $item['idproducto']]);
    if (count($listaP) > 0) {
        $objProd = $listaP[0];
        $stockActual = $objProd->getProCantStock();
        // Si tu array de productos viene con 'cicantidad', úsalo.
        // Si viene como objeto, ajusta a $item->getCiCantidad()
        $cantidadSolicitada = is_array($item) ? $item['cicantidad'] : $item->getCiCantidad();
        
        if ($stockActual < $cantidadSolicitada) {
            $stockOk = false;
            $msgError = "No hay suficiente stock de " . (is_array($item) ? $item['pronombre'] : $objProd->getProNombre());
            break;
        }
    }
}

if (!$stockOk) {
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Compra/mostrarCarrito.php?msg=sin_stock&detalle=".urlencode($msgError));
    exit;
}

// EJECUTAR COMPRA

// A) DESCONTAR STOCK
foreach ($productos as $item) {
    $listaP = $prodCtrl->buscar(['idproducto' => $item['idproducto']]);
    if (count($listaP) > 0) {
        $objProd = $listaP[0];
        $cantidad = is_array($item) ? $item['cicantidad'] : $item->getCiCantidad();
        $nuevoStock = $objProd->getProCantStock() - $cantidad;
        
        $datosProd = [
            'idproducto' => $objProd->getID(),
            'pronombre' => $objProd->getProNombre(),
            'prodetalle' => $objProd->getProDetalle(),
            'procantstock' => $nuevoStock,
            'precio' => $objProd->getPrecio(),
            'proimagen' => $objProd->getImagen()
        ];
        $prodCtrl->modificacion($datosProd);
    }
}

// B) CAMBIAR ESTADO Y ENVIAR MAIL (Delegado al Controlador)
// Aquí llamamos a la función que arreglamos antes en CompraControl
// Esa función se encarga de cerrar el estado 1, abrir el 2 y enviar el Email.
$resultado = $compraCtrl->iniciarCompra($carrito);

// 7. REDIRECCIÓN FINAL
if ($resultado) {
    // Si todo salió bien, vamos a la página de éxito
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/compra/exito.php?id=" . $carrito->getID());
} else {
    // Si falló algo en el estado
    header("Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php?msg=error_procesando");
}
exit;
?>
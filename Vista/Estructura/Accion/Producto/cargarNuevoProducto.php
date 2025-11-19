<?php

require_once __DIR__ . '/../productoControl.php';
require_once __DIR__ . '/../../Util/funciones.php';

$producto = new ProductoControl();
$datos = carga_datos();


$uploadDir = "Util/Imagenes/";

// Datos del archivo subido
$archivo = $datos['imagen'];
$nombreArchivo = basename($archivo['name']); // basename() evita path traversal
$rutaDestino = $uploadDir . $nombreArchivo;

// --- Mover archivo subido ---
if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {

    // Guardamos la ruta RELATIVA que se usará desde la web (por ejemplo, para mostrar imagen en el front)
    $datos['imagen'] = "Util/Imagenes/" . $nombreArchivo;

    // --- Insertar producto en BD ---
    $seRegistro = $producto->alta($datos);

    if ($seRegistro) {
        $message = 'Se ingresó correctamente el producto.';
    } else {
        $message = 'Hubo un error al ingresar el producto.';
    }

} else {
    $message = 'Error al subir la imagen.';
}

// --- Redirección con mensaje ---
header("Location: ../admin/panelAdmin.php?Message=" . urlencode($message));
exit;
?>
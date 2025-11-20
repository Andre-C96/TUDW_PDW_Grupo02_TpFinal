<?php

function carga_datos()
{
    $requestData = array();

    if (!empty($_POST)) {
        $requestData = $_POST;
    } elseif (!empty($_GET)) {
        $requestData = $_GET;
    }
    if (!empty($_FILES)) {
        foreach ($_FILES as $indice => $archivo) {
            $requestData[$indice] = $archivo;
        }
    }
    if (count($requestData)) {
        foreach ($requestData as $indice => $valor) {
            // Evitamos alterar arrays (como los de $_FILES)
            if (!is_array($valor) && $valor === "") {
                $requestData[$indice] = 'null';
            }
        }
    }
    return $requestData;
}

/**
 * Devuelve la URL pública para mostrar una imagen almacenada.
 * Acepta:
 * - valor vacío -> devuelve imagen por defecto
 * - URL absoluta (http/https) -> devuelve tal cual
 * - ruta que comienza con '/' -> devuelve tal cual
 * - si es sólo un nombre de archivo o una ruta relativa, concatena con el prefijo web configurado
 */
function img_public_url($imagen)
{
    if (empty($imagen)) {
        if (isset($GLOBALS['IMAGES_WEB_PREFIX'])) {
            return rtrim($GLOBALS['IMAGES_WEB_PREFIX'], '/') . '/' . ($GLOBALS['IMAGES_DEFAULT'] ?? 'default.png');
        }
        return '/TUDW_PDW_Grupo02_TpFinal/Util/Imagenes/' . ($GLOBALS['IMAGES_DEFAULT'] ?? 'default.png');
    }

    // Si ya es una URL absoluta
    if (preg_match('#^https?://#i', $imagen)) {
        return $imagen;
    }

    // Si comienza con slash, se asume ruta absoluta del sitio
    if (strpos($imagen, '/') === 0) {
        return $imagen;
    }

    // Si ya contiene el prefijo de util/imagenes (por compatibilidad), devolver con prefijo web si hace falta
    if (strpos($imagen, 'Util/Imagenes/') === 0) {
        return '/' . ltrim($imagen, '/');
    }

    // En caso de recibir sólo el nombre de archivo, usar prefijo web global
    if (isset($GLOBALS['IMAGES_WEB_PREFIX'])) {
        return rtrim($GLOBALS['IMAGES_WEB_PREFIX'], '/') . '/' . ltrim($imagen, '/');
    }

    return '/TUDW_PDW_Grupo02_TpFinal/Util/Imagenes/' . ltrim($imagen, '/');
}

/**
 * Sanitiza y genera un nombre de archivo seguro basado en el original
 */
function imagen_generar_nombre_unico($originalName, $prefix = 'img')
{
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $ext = strtolower(preg_replace('/[^a-z0-9]/i', '', $ext));
    if (empty($ext)) {
        $ext = 'png';
    }
    $name = $prefix . '_' . time() . '_' . uniqid();
    return $name . '.' . $ext;
}
?>
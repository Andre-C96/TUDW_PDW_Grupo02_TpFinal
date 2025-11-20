<?php
// Config global del proyecto
// Rutas para imágenes: ruta en filesystem y prefijo web público

// Ruta absoluta en disco donde se guardan las imágenes (termina con slash)
$GLOBALS['IMAGES_FS'] = __DIR__ . '/Util/Imagenes/';

// Prefijo URL público para acceder a las imágenes desde el navegador (termina con slash)
$GLOBALS['IMAGES_WEB_PREFIX'] = '/TUDW_PDW_Grupo02_TpFinal/Util/Imagenes/';

// Compatibilidad con código anterior que usaba $GLOBALS['IMGS']
$GLOBALS['IMGS'] = $GLOBALS['IMAGES_FS'];

// Nombre de imagen por defecto si no hay disponible
$GLOBALS['IMAGES_DEFAULT'] = 'default.png';

?>

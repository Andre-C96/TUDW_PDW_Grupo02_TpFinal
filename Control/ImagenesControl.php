<?php
class ControlImagenes
{
    public function cargarImagen($nombreTabla, $imagen, $nombreCarpeta)
    {
        // Asegurarse de tener la config global cargada
        if (file_exists(__DIR__ . '/../config.php')) {
            require_once __DIR__ . '/../config.php';
        }

        $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $ext = strtolower($ext) ?: 'png';
        $id = time() . uniqid();
        $nombreArchivoImagen = $nombreTabla . '_' . $id . '.' . $ext;

        $dirDestino = rtrim($GLOBALS['IMAGES_FS'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . trim($nombreCarpeta, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        if (!is_dir($dirDestino)) {
            @mkdir($dirDestino, 0755, true);
        }

        $rutaCompleta = $dirDestino . $nombreArchivoImagen;
        $respuesta = false;

        if (is_uploaded_file($imagen['tmp_name'])) {
            if (move_uploaded_file($imagen['tmp_name'], $rutaCompleta)) {
                $respuesta = true;
            }
        } else {
            // Intentar crear desde string (captura previa)
            if (imagepng(imagecreatefromstring(file_get_contents($imagen['tmp_name'])), $rutaCompleta)) {
                $respuesta = true;
            }
        }

        return ['respuesta' => $respuesta, 'nombre' => $nombreArchivoImagen, 'ruta' => $rutaCompleta];
    }

    public function eliminarImagen($nombreArchivoImagen, $nombreCarpeta)
    {
        if (file_exists(__DIR__ . '/../config.php')) {
            require_once __DIR__ . '/../config.php';
        }

        $dir = rtrim($GLOBALS['IMAGES_FS'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . trim($nombreCarpeta, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $nombreArchivoImagen;

        if (file_exists($dir)) {
            @unlink($dir);
        }
    }
}
<?php
// Vista/Estructura/Accion/Menu/cargar.php
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/menuControl.php';

$session = new Session();
if (!$session->sesionActiva()) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

$rolActivo = $session->getRolActivo();
if (empty($rolActivo) || !isset($rolActivo['rol']) || strtolower($rolActivo['rol']) !== 'administrador') {
    echo '<div class="container mt-4"><div class="alert alert-danger">Acceso denegado. Debés ser administrador.</div></div>';
    require_once __DIR__ . '/../../../../Vista/Estructura/footer.php';
    exit;
}

$menuCtrl = new MenuControl();
$mensaje = '';
$tipoMensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['menombre'] ?? '';
    $descripcion = $_POST['medescripcion'] ?? '';
    $idpadre = $_POST['idpadre'] ?? null;

    $param = [
        'menombre' => $nombre,
        'medescripcion' => $descripcion,
        'idpadre' => ($idpadre === '' ? 'null' : $idpadre)
    ];

    $ok = $menuCtrl->alta($param);
    if ($ok) {
        $mensaje = 'Menú creado con éxito.';
        $tipoMensaje = 'success';
    } else {
        $mensaje = 'Error al crear el menú.';
        $tipoMensaje = 'danger';
    }
}

// Para el formulario necesitamos lista de posibles padres
$posiblesPadres = $menuCtrl->buscar([]);

require_once __DIR__ . '/../../../../Vista/admin/cargarMenu.php';

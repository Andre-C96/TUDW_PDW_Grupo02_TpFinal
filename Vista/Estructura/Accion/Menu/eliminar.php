<?php
// Vista/Estructura/Accion/Menu/eliminar.php
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['idmenu'])) {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Menu/listado.php');
    exit;
}

$idmenu = intval($_POST['idmenu']);
$menuCtrl = new MenuControl();
$ok = $menuCtrl->baja(['idmenu' => $idmenu]);

// Redirect back to listado (could add flash messages later)
header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Menu/listado.php');
exit;

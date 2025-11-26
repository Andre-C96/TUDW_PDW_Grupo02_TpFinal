<?php
// Vista/Estructura/Accion/Menu/listado.php
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
$menus = [];
// Obtenemos todos los menus (sin filtro) para administrar
$menuObjs = $menuCtrl->buscar([]);
if (is_array($menuObjs)) {
    foreach ($menuObjs as $m) {
        $menus[] = [
            'idmenu' => $m->getID(),
            'menombre' => $m->getMeNombre(),
            'medescripcion' => $m->getMeDescripcion(),
            'idpadre' => $m->getObjMenuPadre() ? $m->getObjMenuPadre()->getID() : null,
            'medeshabilitado' => $m->getMeDeshabilitado()
        ];
    }
}

require_once __DIR__ . '/../../../../Vista/admin/listadoMenus.php';

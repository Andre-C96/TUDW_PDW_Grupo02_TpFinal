<?php
// Vista/Estructura/Accion/Auth/login.php
// Acción que procesa el login y redirige según rol activo
require_once __DIR__ . '/../../../../Control/Session.php';
require_once __DIR__ . '/../../../../Control/usuarioControl.php';

$session = new Session();
if (!$session->activa()) {
    // iniciar la session si hace falta
    // el constructor de Session intenta start()
    $session = new Session();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

$usnombre = isset($_POST['usnombre']) ? trim($_POST['usnombre']) : '';
$uspass = isset($_POST['uspass']) ? trim($_POST['uspass']) : '';

if ($usnombre === '' || $uspass === '') {
    $_SESSION['flash'] = 'Complete usuario y contraseña.';
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// Intentar iniciar sesión
$ok = $session->iniciar($usnombre, $uspass);
if (!$ok) {
    $_SESSION['flash'] = 'Credenciales inválidas.';
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php');
    exit;
}

// Sesión iniciada; obtener rol activo
$rolActivo = $session->getRolActivo();
// default to project index
$dest = '/TUDW_PDW_Grupo02_TpFinal/Vista/index.php';
if (!empty($rolActivo) && isset($rolActivo['rol'])) {
    $rol = strtolower($rolActivo['rol']);
    // redirección por rol (ajustá rutas según lo que tengamos)
    if ($rol === 'administrador') {
        $dest = '/TUDW_PDW_Grupo02_TpFinal/Vista/admin/dashboard.php';
    } elseif ($rol === 'cliente') {
        $dest = '/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php';
    } elseif ($rol === 'deposito' || $rol === 'depositista') {
        $dest = '/TUDW_PDW_Grupo02_TpFinal/Vista/deposito/index.php';
    } else {
        $dest = '/TUDW_PDW_Grupo02_TpFinal/Vista/index.php';
    }
}

header('Location: ' . $dest);
exit;

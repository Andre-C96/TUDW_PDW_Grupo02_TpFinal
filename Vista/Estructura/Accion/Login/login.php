<?php
// Vista/Estructura/Accion/Login/login.php

$root = __DIR__ . '/../../../../';
require_once $root . 'Control/Session.php';

//  Recibir datos
// Usamos $_POST para recibir los datos del formulario de la vista
$usNombre = $_POST['usnombre'] ?? '';
$usPass = $_POST['uspass'] ?? '';

// Crear objeto e invocar método
$session = new Session();

// Función para buscar, validar, setear sesión.
if ($session->LoginUsuario($usNombre, $usPass)) {
    // Éxito: Redirigir al inicio o al panel de control
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/index.php');
} else {
    // Fallo: Redirigir al formulario de login con un mensaje de error
    $message = "Usuario o contraseña incorrectos, o usuario deshabilitado.";
    header('Location: /TUDW_PDW_Grupo02_TpFinal/Vista/login.php?msg=' . urlencode($message));
}
exit;
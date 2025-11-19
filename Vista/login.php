<?php
// Vista/login.php - simple formulario de login
require_once __DIR__ . '/Estructura/header.php';
?>
<div class="container mt-4">
    <h2>Iniciar sesión</h2>
    <?php if (isset($_SESSION['flash'])) { echo '<div class="alert alert-info">'.htmlspecialchars($_SESSION['flash']).'</div>'; unset($_SESSION['flash']); } ?>
    <form method="post" action="/Vista/Estructura/Accion/Auth/login.php">
        <div class="mb-3">
            <label for="usnombre" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usnombre" name="usnombre" required>
        </div>
        <div class="mb-3">
            <label for="uspass" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="uspass" name="uspass" required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>

<?php require_once __DIR__ . '/Estructura/footer.php'; ?>

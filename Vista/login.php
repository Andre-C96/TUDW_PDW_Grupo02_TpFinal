<?php
// Vista/login.php - simple formulario de login
require_once __DIR__ . '/Estructura/header.php';
?>

<style>
    .login-page {
        min-height: calc(100vh - 160px); /* deja espacio para header/footer */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 12px;
    }
    .login-card {
        width: 100%;
        max-width: 420px;
        border-radius: 8px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        padding: 20px;
        background: #fff;
    }
    .btn-pine {
        background: var(--pine-green, #01796F);
        border-color: var(--pine-green, #01796F);
        color: #fff;
    }
    .btn-pine:hover, .btn-pine:focus {
        background: #016a5f;
        border-color: #016a5f;
        color: #fff;
    }
</style>

<div class="login-page">
    <div class="login-card">
        <h3 class="mb-3 text-center" style="color:var(--pine-green,#01796F);">Iniciar sesión</h3>
        <?php if (isset($_SESSION['flash'])) { echo '<div class="alert alert-info">'.htmlspecialchars($_SESSION['flash']).'</div>'; unset($_SESSION['flash']); } ?>
        <form method="post" action="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Login/login.php">
            <div class="mb-3">
                <label for="usnombre" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usnombre" name="usnombre" required>
            </div>
            <div class="mb-3">
                <label for="uspass" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="uspass" name="uspass" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-pine">Entrar</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/Estructura/footer.php'; ?>

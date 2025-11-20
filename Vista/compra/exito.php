<?php

require_once __DIR__ . '/../Estructura/header.php';

// Recibimos el ID de la compra
$idCompra = $_GET['id'] ?? '---';


$navidadRojo = '#d90429'; 
$navidadVerde = '#198754'; 
?>

<style>
    /* Pequeños retoques para los botones navideños */
    .btn-navidad-verde { background-color: <?php echo $navidadVerde; ?>; border-color: <?php echo $navidadVerde; ?>; color: white; }
    .btn-navidad-verde:hover { background-color: #146c43; color: white; }
    .btn-outline-navidad-rojo { color: <?php echo $navidadRojo; ?>; border-color: <?php echo $navidadRojo; ?>; }
    .btn-outline-navidad-rojo:hover { background-color: <?php echo $navidadRojo; ?>; color: white; }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-lg text-center p-5 border-0" style="max-width: 500px; border-top: 8px solid <?php echo $navidadRojo; ?> !important; border-bottom: 3px solid <?php echo $navidadVerde; ?> !important;">
        

        <h2 class="mb-3 fw-bold" style="color: <?php echo $navidadRojo; ?>;">¡Compra Exitosa!</h2>
        
        <p class="text-muted mb-4">
            Tu pedido ha sido recibido correctamente. ¡Pronto estará debajo de tu arbolito!
        </p>

        <div class="alert py-2 mb-4" style="background-color: #f8d7da; border-color: <?php echo $navidadRojo; ?>; color: #842029;">
            <small class="text-uppercase fw-bold" style="color: <?php echo $navidadRojo; ?>;">Número de Compra</small><br>
            <span class="fs-4 fw-bold">#<?php echo htmlspecialchars($idCompra); ?></span>
        </div>

        <p class="small text-muted mb-4">
            Te hemos enviado un correo electrónico de confirmación.
        </small>

        <div class="d-grid gap-3">
            <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/Accion/Producto/listado.php" class="btn btn-navidad-verde btn-lg shadow-sm">
                <i class="bi bi-gift-fill me-2"></i>Seguir Comprando
            </a>
            <a href="/TUDW_PDW_Grupo02_TpFinal/Vista/index.php" class="btn btn-outline-navidad-rojo">
                Volver al Inicio
            </a>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../Estructura/footer.php'; ?>
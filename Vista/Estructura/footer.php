<?php
// Vista/Estructura/footer.php
?>

<!-- Footer fijo inferior -->
<style>
	/* Asegura que el footer quede fijo en la parte inferior y evita solapamiento con contenido */
	.fixed-footer {
		position: fixed;
		bottom: 0;
		left: 0;
		width: 100%;
		z-index: 1030;
		background: #ffffff;
		border-top: 2px solid #dc3545;
		color: #01796F;
	}
	/* Dejar espacio en el body para que el contenido no quede tapado por el footer */
	body { padding-bottom: 80px; }
	@media (max-width: 576px) {
		body { padding-bottom: 100px; }
	}
</style>

<footer class="text-center fixed-footer">
	<div class="container py-3 d-flex align-items-center">
		<div class="mx-auto text-center w-100">
			<small style="color:inherit">&copy; <?php echo date('Y'); ?> ChristmasMarket</small>
		</div>
	</div>
</footer>

<!-- Scripts: jQuery (slim) y Bootstrap bundle -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/js/bootstrap.bundle.min.js"></script>
<script src="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/js/main.js"></script>

</body>
</html>


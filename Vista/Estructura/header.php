<?php
// Vista/Estructura/header.php
// Header común con Bootstrap navbar
?>
<!doctype html>
<html lang="es">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ChrismasMarket</title>
		<link href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/css/bootstrap.min.css" rel="stylesheet">
		<link href="/TUDW_PDW_Grupo02_TpFinal/Vista/Estructura/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
		<a class="navbar-brand" href="/TUDW_PDW_Grupo02_TpFinal/Vista/index.php">ChrismasMarket</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<?php
			// El header no debe decidir rutas ni roles: el action debe preparar $menuData.
			// Estructura esperada: $menuData = ['left'=> [ ['url'=>'...','label'=>'...'], ... ], 'right'=>[...] ]
			if (isset($menuData) && is_array($menuData)) {
				echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">';
				if (!empty($menuData['left'])) {
					foreach ($menuData['left'] as $item) {
						$url = isset($item['url']) ? $item['url'] : '#';
						$label = isset($item['label']) ? $item['label'] : (isset($item['nombre']) ? $item['nombre'] : 'Menu');
						echo '<li class="nav-item"><a class="nav-link" href="'.htmlspecialchars($url).'">'.htmlspecialchars($label).'</a></li>';
					}
				}
				echo '</ul>';

				echo '<ul class="navbar-nav">';
				if (!empty($menuData['right'])) {
					foreach ($menuData['right'] as $item) {
						$url = isset($item['url']) ? $item['url'] : '#';
						$label = isset($item['label']) ? $item['label'] : (isset($item['nombre']) ? $item['nombre'] : 'Accion');
						echo '<li class="nav-item"><a class="nav-link" href="'.htmlspecialchars($url).'">'.htmlspecialchars($label).'</a></li>';
					}
				} else {
					echo '<li class="nav-item"><a class="nav-link" href="/TUDW_PDW_Grupo02_TpFinal/Vista/login.php">Login</a></li>';
				}
				echo '</ul>';
			} else {
				// fallback mínimo: Inicio + Login
				echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">';
				echo '<li class="nav-item"><a class="nav-link" href="/TUDW_PDW_Grupo02_TpFinal/Vista/index.php">Inicio</a></li>';
				echo '</ul>';
				echo '<ul class="navbar-nav">';
				echo '<li class="nav-item"><a class="nav-link" href="/TUDW_PDW_Grupo02_TpFinal/Vista/login.php">Login</a></li>';
				echo '</ul>';
			}
			?>
		</div>
	</div>
</nav>


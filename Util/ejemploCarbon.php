<?php
/**
 * Ejemplo de uso de Carbon en el proyecto
 * Carbon es una librería para trabajar con fechas y horas de manera más sencilla
 */

// Incluir el autoload de Composer para cargar Carbon
require_once __DIR__ . '/../vendor/autoload.php';

use Carbon\Carbon;

// ====================================
// EJEMPLOS DE USO DE CARBON
// ====================================

// 1. Obtener la fecha y hora actual
$ahora = Carbon::now();
echo "Fecha y hora actual: " . $ahora . "\n";
echo "Formato personalizado: " . $ahora->format('d/m/Y H:i:s') . "\n\n";

// 2. Crear una fecha específica
$fecha = Carbon::create(2025, 12, 25, 0, 0, 0); // Navidad 2025
echo "Navidad 2025: " . $fecha->format('d/m/Y') . "\n\n";

// 3. Parsear una fecha desde string
$fechaString = Carbon::parse('2025-11-19');
echo "Fecha parseada: " . $fechaString->format('d/m/Y') . "\n\n";

// 4. Operaciones con fechas
$manana = Carbon::now()->addDay();
echo "Mañana: " . $manana->format('d/m/Y') . "\n";

$ayer = Carbon::now()->subDay();
echo "Ayer: " . $ayer->format('d/m/Y') . "\n";

$dentroDeUnaSemana = Carbon::now()->addWeek();
echo "Dentro de una semana: " . $dentroDeUnaSemana->format('d/m/Y') . "\n\n";

// 5. Diferencias entre fechas
$inicio = Carbon::parse('2025-01-01');
$fin = Carbon::parse('2025-12-31');
$diferencia = $inicio->diffInDays($fin);
echo "Días entre inicio y fin de 2025: " . $diferencia . " días\n\n";

// 6. Comparar fechas
$fecha1 = Carbon::parse('2025-11-19');
$fecha2 = Carbon::parse('2025-12-25');

if ($fecha1->isBefore($fecha2)) {
    echo "19 de noviembre es antes que 25 de diciembre\n";
}

if ($fecha2->isAfter($fecha1)) {
    echo "25 de diciembre es después que 19 de noviembre\n";
}

// 7. Formato para humanos (hace 2 días, en 3 semanas, etc.)
Carbon::setLocale('es'); // Establecer idioma español
$hace3dias = Carbon::now()->subDays(3);
echo "\nFormato humano: " . $hace3dias->diffForHumans() . "\n";

$en5dias = Carbon::now()->addDays(5);
echo "Formato humano: " . $en5dias->diffForHumans() . "\n\n";

// 8. Obtener partes de la fecha
echo "Año: " . $ahora->year . "\n";
echo "Mes: " . $ahora->month . "\n";
echo "Día: " . $ahora->day . "\n";
echo "Día de la semana: " . $ahora->dayOfWeek . "\n";
echo "Nombre del día: " . $ahora->translatedFormat('l') . "\n"; // Necesita setLocale('es')
echo "Nombre del mes: " . $ahora->translatedFormat('F') . "\n\n";

// 9. Inicio y fin de períodos
echo "Inicio del mes: " . Carbon::now()->startOfMonth()->format('d/m/Y') . "\n";
echo "Fin del mes: " . Carbon::now()->endOfMonth()->format('d/m/Y') . "\n";
echo "Inicio de la semana: " . Carbon::now()->startOfWeek()->format('d/m/Y') . "\n";
echo "Fin de la semana: " . Carbon::now()->endOfWeek()->format('d/m/Y') . "\n\n";

// ====================================
// EJEMPLOS APLICADOS AL PROYECTO
// ====================================

// Ejemplo 1: Formatear fecha de compra para mostrar en listado
function formatearFechaCompra($fechaBD) {
    return Carbon::parse($fechaBD)->format('d/m/Y H:i');
}

// Ejemplo 2: Verificar si una compra se puede cancelar (por ejemplo, solo si tiene menos de 24 horas)
function puedeCancelarCompra($fechaCompra) {
    $fecha = Carbon::parse($fechaCompra);
    $ahora = Carbon::now();
    $horasDiferencia = $fecha->diffInHours($ahora);
    return $horasDiferencia < 24;
}

// Ejemplo 3: Calcular tiempo de entrega estimado
function fechaEntregaEstimada($fechaCompra, $diasEstimados = 7) {
    return Carbon::parse($fechaCompra)->addDays($diasEstimados)->format('d/m/Y');
}

// Ejemplo 4: Obtener compras del último mes
function esDelUltimoMes($fechaCompra) {
    $fecha = Carbon::parse($fechaCompra);
    $unMesAtras = Carbon::now()->subMonth();
    return $fecha->isAfter($unMesAtras);
}

echo "=== EJEMPLOS APLICADOS ===\n";
$fechaCompraEjemplo = '2025-11-19 14:30:00';
echo "Fecha formateada: " . formatearFechaCompra($fechaCompraEjemplo) . "\n";
echo "Puede cancelar: " . (puedeCancelarCompra($fechaCompraEjemplo) ? 'Sí' : 'No') . "\n";
echo "Fecha entrega estimada: " . fechaEntregaEstimada($fechaCompraEjemplo) . "\n";
echo "Es del último mes: " . (esDelUltimoMes($fechaCompraEjemplo) ? 'Sí' : 'No') . "\n";
?>

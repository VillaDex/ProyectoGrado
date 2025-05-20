<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Compra;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        $semanas = $this->generarSemanasDisponibles();
        $semanaActual = $this->getSemanaActual();

        return view('reportes.index', [
            'semanas' => $semanas,
            'fechaInicioDefault' => $semanaActual['inicio'],
            'fechaFinDefault' => $semanaActual['fin']
        ]);
    }

    // Métodos para Ventas
    public function mostrarPreviaVentas(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        $fechas = $this->procesarFechasSemana($request->fecha_inicio, $request->fecha_fin);
        $datos = $this->procesarDatosVentas($fechas['inicio'], $fechas['fin']);
        $datos['rango_semanal'] = $fechas;

        return view('reportes.previa_ventas', $datos);
    }

    public function descargarVentas(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date'
    ]);

    $fechas = $this->procesarFechasSemana($request->fecha_inicio, $request->fecha_fin);
    $datos = $this->procesarDatosVentas($fechas['inicio'], $fechas['fin']);
    $datos['rango_semanal'] = $fechas;

    $pdf = Pdf::loadView('reportes.ventas_pdf', $datos)
        ->setPaper('a4', 'landscape')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', true)
        ->setOption('defaultFont', 'Helvetica')
        ->setOption('isPhpEnabled', true)
        ->setOption('dpi', 150)
        ->setOption('margin-top', 10)
        ->setOption('margin-bottom', 10)
        ->setOption('margin-left', 10)
        ->setOption('margin-right', 10);

    return $pdf->download("reporte_ventas_semana_{$fechas['numero_semana']}.pdf");
}

    // Métodos para Compras
    public function mostrarPreviaCompras(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        $fechas = $this->procesarFechasSemana($request->fecha_inicio, $request->fecha_fin);
        $datos = $this->procesarDatosCompras($fechas['inicio'], $fechas['fin']);
        $datos['rango_semanal'] = $fechas;

        return view('reportes.previa_compras', $datos);
    }

    public function descargarCompras(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date'
    ]);

    $fechas = $this->procesarFechasSemana($request->fecha_inicio, $request->fecha_fin);
    $datos = $this->procesarDatosCompras($fechas['inicio'], $fechas['fin']);
    $datos['rango_semanal'] = $fechas;

    $pdf = Pdf::loadView('reportes.compras_pdf', $datos)
        ->setPaper('a4', 'landscape')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', true)
        ->setOption('defaultFont', 'Helvetica')
        ->setOption('isPhpEnabled', true)
        ->setOption('dpi', 150)
        ->setOption('margin-top', 10)
        ->setOption('margin-bottom', 10)
        ->setOption('margin-left', 10)
        ->setOption('margin-right', 10);

    return $pdf->download("reporte_compras_semana_{$fechas['numero_semana']}.pdf");
}
    // Métodos auxiliares
    private function generarSemanasDisponibles()
    {
        $semanas = [];
        $hoy = now();
        
        for ($i = 8; $i >= 0; $i--) {
            $fecha = $hoy->copy()->subWeeks($i);
            $inicio = $fecha->copy()->startOfWeek();
            $fin = $fecha->copy()->endOfWeek();
            
            $semanas[] = [
                'value' => $inicio->format('Y-m-d').'_'.$fin->format('Y-m-d'),
                'label' => 'Semana '.$inicio->weekOfYear.' ('.$inicio->format('d/m').' - '.$fin->format('d/m').')',
                'selected' => $i === 0
            ];
        }
        
        return $semanas;
    }

    private function getSemanaActual()
    {
        $inicio = now()->startOfWeek();
        $fin = now()->endOfWeek();
        
        return [
            'inicio' => $inicio->format('Y-m-d'),
            'fin' => $fin->format('Y-m-d'),
            'numero_semana' => $inicio->weekOfYear,
            'anio' => $inicio->year
        ];
    }

    private function procesarFechasSemana($fechaInicio, $fechaFin)
    {
        $inicio = Carbon::parse($fechaInicio)->startOfDay();
        $fin = Carbon::parse($fechaFin)->endOfDay();
        
        return [
            'inicio' => $inicio->format('Y-m-d'),
            'fin' => $fin->format('Y-m-d'),
            'inicio_obj' => $inicio,
            'fin_obj' => $fin,
            'numero_semana' => $inicio->weekOfYear,
            'anio' => $inicio->year,
            'rango_texto' => $inicio->format('d/m/Y').' al '.$fin->format('d/m/Y')
        ];
    }

    private function procesarDatosVentas($fechaInicio, $fechaFin)
    {
        $ventas = Venta::with(['cliente', 'producto'])
                     ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
                     ->get();

        $totalVentas = $ventas->sum('precio');
        $ventasPorDia = $this->procesarParaGrafica($ventas, 'fecha_hora');

        return [
            'ventas' => $ventas,
            'ventasPorDia' => $ventasPorDia,
            'total_ventas' => $totalVentas
        ];
    }

    private function procesarDatosCompras($fechaInicio, $fechaFin)
    {
        $compras = Compra::with(['proveedor', 'producto'])
                       ->whereBetween('fecha_compra', [$fechaInicio, $fechaFin])
                       ->get();

        $totalCompras = $compras->sum('precio');
        $comprasPorDia = $this->procesarParaGrafica($compras, 'fecha_compra');

        return [
            'compras' => $compras,
            'comprasPorDia' => $comprasPorDia,
            'total_compras' => $totalCompras
        ];
    }

    private function procesarParaGrafica($registros, $campoFecha)
    {
        return $registros->groupBy(function($registro) use ($campoFecha) {
            return Carbon::parse($registro->{$campoFecha})->format('Y-m-d');
        })->map(function($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum('precio')
            ];
        });
    }
}
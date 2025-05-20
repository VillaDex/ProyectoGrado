<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Semanal de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .reporte-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        .resumen-semana {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .grafica-container { margin: 40px 0; }
        .chart {
            display: flex;
            height: 300px;
            align-items: flex-end;
            gap: 15px;
            padding: 20px 0;
        }
        .chart-bar-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .chart-bar {
            width: 80%;
            background: #007bff;
            border-radius: 5px 5px 0 0;
            transition: height 0.5s;
            min-height: 5px;
        }
        .chart-label {
            margin-top: 10px;
            font-size: 12px;
            color: #6c757d;
        }
        .chart-value { font-weight: bold; color: #2c3e50; }
        .dia-activo { background-color: #e7f0fd; }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="reporte-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-shopping-cart text-primary me-2"></i>Reporte Semanal de Compras</h1>
                <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>

            <div class="resumen-semana">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3">Semana {{ $rango_semanal['numero_semana'] }} - {{ $rango_semanal['anio'] }}</h4>
                        <p class="mb-1"><strong>Periodo:</strong> {{ $rango_semanal['rango_texto'] }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h4 class="text-primary">Total Compras: ${{ number_format($total_compras, 2) }}</h4>
                        <p class="mb-0"><strong>Cantidad de transacciones:</strong> {{ $compras->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="grafica-container">
                <h4><i class="fas fa-chart-bar me-2"></i></h4>
                <div class="chart">
                    @php
                        $diasSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
                        $maxValor = max($comprasPorDia->max('total') ?? 1, 1);
                        $hoy = now();
                        $inicioSemana = \Carbon\Carbon::parse($rango_semanal['inicio']);
                    @endphp
                    
                    @foreach($diasSemana as $index => $dia)
                    @php
                        $diaFecha = $inicioSemana->copy()->addDays($index);
                        $comprasDia = $comprasPorDia[$diaFecha->format('Y-m-d')] ?? ['total' => 0];
                        $totalDia = $comprasDia['total'];
                        $esHoy = $diaFecha->isToday();
                        $altura = $maxValor > 0 ? ($totalDia / $maxValor) * 300 : 0;
                    @endphp
                    <div class="chart-bar-container {{ $esHoy ? 'dia-activo' : '' }}">
                        <div class="chart-bar" style="height: {{ $altura }}px;"></div>
                        <span class="chart-label">{{ $dia }}</span>
                        <span class="chart-value">${{ number_format($totalDia, 0) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>P. Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($compras as $compra)
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
                            <td>{{ $compra->proveedor->nombre }}</td>
                            <td>{{ $compra->producto->nombre }}</td>
                            <td>{{ $compra->cantidad }}</td>
                            <td>${{ number_format($compra->precio_unitario, 2) }}</td>
                            <td>${{ number_format($compra->precio, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <td colspan="6" class="text-end"><strong>Total Semana:</strong></td>
                            <td><strong>${{ number_format($total_compras, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
                <form action="{{ route('reportes.compras.descargar') }}" method="GET">
                    <input type="hidden" name="fecha_inicio" value="{{ $rango_semanal['inicio'] }}">
                    <input type="hidden" name="fecha_fin" value="{{ $rango_semanal['fin'] }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-pdf me-1"></i> Descargar PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
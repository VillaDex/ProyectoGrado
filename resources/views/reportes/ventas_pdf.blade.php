<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Semanal de Ventas</title>
    <style type="text/css">
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 15px;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .container {
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #28a745;
        }
        .header h1 {
            color: #28a745;
            margin: 0 0 5px 0;
            font-size: 22px;
            font-weight: bold;
        }
        .resumen {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .total-box {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
        }
        
        /* ENFOQUE PARA GRÁFICA HORIZONTAL */
        .grafica-container {
            margin: 25px 0;
            width: 100%;
            page-break-inside: avoid;
        }
        .grafica-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .chart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        .chart-table td {
            vertical-align: bottom;
            text-align: center;
            width: 14.28%; /* 100% / 7 días */
            padding: 0 5px;
        }
        .bar-container {
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        .chart-bar {
            background-color: #4e73df;
            border-radius: 4px 4px 0 0;
            min-height: 1px;
            width: 70%;
            margin: 0 auto;
            display: none; /* Ocultar por defecto */
        }
        .chart-bar.has-value {
            display: block; /* Mostrar solo cuando hay valor */
        }
        .chart-label {
            margin-top: 8px;
            font-size: 11px;
        }
        .chart-value {
            font-weight: bold;
            font-size: 11px;
            margin-top: 3px;
        }
        .chart-value.zero {
            color: #999; /* Color más tenue para valores cero */
        }
        
        .table-container {
            margin-top: 30px;
            width: 100%;
            page-break-inside: avoid;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .data-table th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
        }
        .data-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .data-table tfoot td {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>REPORTE SEMANAL DE VENTAS</h1>
            <div>Semana {{ $rango_semanal['numero_semana'] }} - {{ $rango_semanal['anio'] }}</div>
        </div>

        <div class="resumen">
            <div>
                <div><strong>Período:</strong> {{ $rango_semanal['rango_texto'] }}</div>
                <div><strong>Transacciones:</strong> {{ $ventas->count() }}</div>
            </div>
            <div class="total-box">TOTAL: ${{ number_format($total_ventas, 2) }}</div>
        </div>

        <!-- GRÁFICA HORIZONTAL CON TABLA - MODIFICADA -->
        <div class="grafica-container">
            <div class="grafica-title">VENTAS POR DÍA</div>
            <table class="chart-table">
                <tr>
                    @php
                        $diasSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
                        $maxValor = max($ventasPorDia->max('total') ?? 1, 1);
                        $inicioSemana = \Carbon\Carbon::parse($rango_semanal['inicio']);
                    @endphp
                    
                    @foreach($diasSemana as $index => $dia)
                    @php
                        $diaFecha = $inicioSemana->copy()->addDays($index);
                        $ventasDia = $ventasPorDia[$diaFecha->format('Y-m-d')] ?? ['total' => 0];
                        $totalDia = $ventasDia['total'];
                        $altura = $maxValor > 0 ? ($totalDia / $maxValor) * 150 : 1;
                        $hasValue = $totalDia > 0;
                    @endphp
                    <td>
                        <div class="bar-container">
                            <div class="chart-bar {{ $hasValue ? 'has-value' : '' }}" style="height: {{ $altura }}px;"></div>
                        </div>
                        <div class="chart-label">{{ $dia }}</div>
                        <div class="chart-value {{ !$hasValue ? 'zero' : '' }}">${{ number_format($totalDia, 0) }}</div>
                    </td>
                    @endforeach
                </tr>
            </table>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>FECHA</th>
                        <th>CLIENTE</th>
                        <th>PRODUCTO</th>
                        <th>PRECIO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_hora)->format('d/m H:i') }}</td>
                        <td>{{ $venta->cliente->nombre }}</td>
                        <td>{{ $venta->producto->nombre }}</td>
                        <td>${{ number_format($venta->precio, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;">TOTAL SEMANA:</td>
                        <td>${{ number_format($total_ventas, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer">
            Generado el {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
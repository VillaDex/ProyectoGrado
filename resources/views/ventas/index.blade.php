<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/welcome.css?<?= filemtime(public_path('css/welcome.css')) ?>" />
    <!-- Estilos para impresión y PDF -->
    <style>
        /* Estilos específicos para impresión y PDF */
        @media print {
            /* Ocultar elementos que no se necesitan en la impresión */
            .navbar, .sidebar, .btn, form, .nav-item, .table .btn, 
            .table form, .input-group, .mb-3, .mb-4 {
                display: none !important;
            }
            
            /* Ocultar específicamente la columna de acciones */
            .no-print {
                display: none !important;
            }
            
            /* Estilo general para la página */
            body {
                font-family: 'Arial', sans-serif;
                background-color: white;
                color: #333;
                margin: 2cm;
            }
            
            /* Encabezado de la página */
            .content {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            /* Título principal */
            h1 {
                color: #2c3e50;
                text-align: center;
                font-size: 24pt;
                margin-bottom: 20px;
                border-bottom: 2px solid #3498db;
                padding-bottom: 10px;
            }
            
            /* Añadir logo o nombre de empresa */
            h1:before {
                content: "Sistema Inventario";
                display: block;
                font-size: 14pt;
                color: #7f8c8d;
                margin-bottom: 5px;
            }
            
            /* Tabla de datos */
            .table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                page-break-inside: auto;
            }
            
            /* Encabezados de tabla */
            .table thead {
                background-color: #3498db !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .table th {
                padding: 12px 8px;
                text-align: left;
                font-weight: bold;
                border-bottom: 2px solid #3498db;
            }
            
            /* Filas de la tabla */
            .table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            .table td {
                padding: 10px 8px;
                border-bottom: 1px solid #e0e0e0;
            }
            
            /* Filas alternas */
            .table tbody tr:nth-child(even) {
                background-color: #f8f9fa;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            /* Pie de página con información de impresión */
            .content:after {
                content: "Fecha de impresión: " attr(data-print-date) " - Página " attr(data-page) " de " attr(data-total);
                display: block;
                text-align: center;
                font-size: 10pt;
                color: #7f8c8d;
                margin-top: 30px;
                border-top: 1px solid #e0e0e0;
                padding-top: 10px;
            }
            
            /* Ajuste para que todas las columnas tengan un ancho apropiado */
            .table th:nth-child(1), .table td:nth-child(1) { width: 5%; }  /* ID */
            .table th:nth-child(2), .table td:nth-child(2) { width: 20%; } /* Cliente */
            .table th:nth-child(3), .table td:nth-child(3) { width: 25%; } /* Producto */
            .table th:nth-child(4), .table td:nth-child(4) { width: 10%; } /* Cantidad */
            .table th:nth-child(5), .table td:nth-child(5) { width: 15%; } /* Precio */
            .table th:nth-child(6), .table td:nth-child(6) { width: 25%; } /* Fecha y Hora */
            
            /* Mostrar solo elementos de impresión */
            .print-only {
                display: block !important;
            }
            
            /* Estilos para el encabezado de impresión */
            .print-header {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .print-logo {
                font-size: 18pt;
                font-weight: bold;
                color: #3498db;
                margin-bottom: 10px;
            }
            
            .print-header h2 {
                font-size: 22pt;
                margin: 10px 0;
                color: #2c3e50;
            }
            
            .print-date {
                font-size: 12pt;
                color: #7f8c8d;
            }
        }
        
        /* Estilos específicos para el PDF */
        #reportePDF {
            display: none;
            background-color: white;
            font-family: 'Arial', sans-serif;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        #reportePDF .pdf-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        #reportePDF .pdf-logo {
            font-size: 18pt;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 10px;
        }
        
        #reportePDF h2 {
            font-size: 22pt;
            margin: 10px 0;
            color: #2c3e50;
        }
        
        #reportePDF .pdf-date {
            font-size: 12pt;
            color: #7f8c8d;
        }
        
        #reportePDF table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        #reportePDF table th {
            background-color: #3498db;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #3498db;
        }
        
        #reportePDF table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        #reportePDF table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        #reportePDF .pdf-footer {
            text-align: center;
            font-size: 10pt;
            color: #7f8c8d;
            margin-top: 30px;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }
        
        /* Ocultar elementos de impresión en pantalla */
        .print-only {
            display: none;
        }
        
        /* Ocultar temporalmente */
        .temp-hide {
            display: none !important;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <i class="fas fa-box-open"></i>
            <span>Sistema Inventario</span>
        </div>
    </nav>
    
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-box-open fa-2x"></i>
            <h3>Inventario</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ route('ventas.index') }}" class="nav-link active"><i class="fas fa-cash-register"></i> Ventas</a></li>
        </ul>
    </div>
    
    <div class="content">
        <div class="container mt-4">
            <h1 class="mb-4">Lista de Ventas</h1>
            <a href="{{ route('ventas.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Nueva Venta</a>
       
            
            <!-- Formulario de búsqueda avanzada -->
            <form action="{{ route('ventas.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="cliente" class="form-control" placeholder="Buscar por nombre de cliente" value="{{ request('cliente') }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-primary w-100" type="submit"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            
            <div class="card p-4">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Fecha y Hora</th>
                            <th class="no-print">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                        <tr>
                            <td>{{ $venta->id }}</td>
                            <td>{{ $venta->cliente->nombre }}</td>
                            <td>{{ $venta->producto->nombre }}</td>
                            <td>{{ $venta->cantidad }}</td>
                            <td>{{ $venta->precio }}</td>
                            <td>{{ $venta->fecha_hora }}</td>
                            <td class="no-print">
                                <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('welcome') }}" class="btn btn-secondary mt-3"><i class="fas fa-home"></i> Volver al Inicio</a>
        </div>
    </div>
    
    <!-- Elemento oculto para generar el PDF -->
    <div id="reportePDF">
        <div class="pdf-header">
            <div class="pdf-logo">
                <i class="fas fa-box-open"></i> Sistema Inventario
            </div>
            <h2>Reporte de Ventas</h2>
            <p class="pdf-date" id="pdfDate">Fecha: </p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>
            <tbody id="pdfTableBody">
                <!-- El contenido de la tabla se generará dinámicamente -->
            </tbody>
        </table>
        
        <div class="pdf-footer" id="pdfFooter">
            <!-- El pie de página se generará dinámicamente -->
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Incluir la librería html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Script para la funcionalidad de impresión y descarga PDF -->
    <script>
        // Función para preparar la impresión
        function prepararImpresion() {
            // Obtener la fecha actual formateada
            const fechaActual = new Date();
            const fechaFormateada = fechaActual.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Agregar atributos personalizados al contenedor
            document.querySelector('.content').setAttribute('data-print-date', fechaFormateada);
            
            // Agregar título con la información
            let tituloImpresion = document.createElement('div');
            tituloImpresion.className = 'print-only print-header';
            tituloImpresion.innerHTML = `
                <div class="print-logo">
                    <i class="fas fa-box-open"></i> Sistema Inventario
                </div>
                <h2>Reporte de Ventas</h2>
                <p class="print-date">Fecha: ${fechaFormateada}</p>
            `;
            
            // Insertar al principio del contenido
            let contenido = document.querySelector('.content .container');
            contenido.insertBefore(tituloImpresion, contenido.firstChild);
            
            // Ocultar temporalmente elementos que no se necesitan imprimir
            document.querySelectorAll('.btn, form.mb-4').forEach(el => {
                el.classList.add('temp-hide');
            });
            
            // Iniciar impresión
            window.print();
            
            // Restaurar elementos después de imprimir
            window.addEventListener('afterprint', function() {
                document.querySelectorAll('.temp-hide').forEach(el => {
                    el.classList.remove('temp-hide');
                });
                
                // Eliminar título de impresión temporal
                if (document.querySelector('.print-header')) {
                    document.querySelector('.print-header').remove();
                }
            });
        }

        // Función para generar y descargar el PDF
        function generarPDF() {
            // Obtener la fecha actual formateada
            const fechaActual = new Date();
            const fechaFormateada = fechaActual.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Actualizar fecha en el elemento PDF
            document.getElementById('pdfDate').textContent = `Fecha: ${fechaFormateada}`;
            
            // Copiar datos de la tabla original al elemento PDF
            const pdfTableBody = document.getElementById('pdfTableBody');
            pdfTableBody.innerHTML = '';
            
            // Obtener filas de la tabla original (excluyendo las acciones)
            const filasOriginales = document.querySelectorAll('.table tbody tr');
            filasOriginales.forEach(fila => {
                const nuevaFila = document.createElement('tr');
                
                // Obtener todas las celdas excepto la última (acciones)
                const celdas = fila.querySelectorAll('td:not(.no-print)');
                celdas.forEach(celda => {
                    const nuevaCelda = document.createElement('td');
                    nuevaCelda.textContent = celda.textContent.trim();
                    nuevaFila.appendChild(nuevaCelda);
                });
                
                pdfTableBody.appendChild(nuevaFila);
            });
            
            // Actualizar pie de página
            document.getElementById('pdfFooter').textContent = `Fecha de generación: ${fechaFormateada}`;
            
            // Configurar opciones de html2pdf
            const opciones = {
                margin: [10, 10, 10, 10],
                filename: `Reporte_Ventas_${fechaActual.toISOString().split('T')[0]}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            // Generar PDF
            const elementoParaPDF = document.getElementById('reportePDF');
            
            // Mostrar elemento antes de generar el PDF
            elementoParaPDF.style.display = 'block';
            
            // Generar y descargar el PDF
            html2pdf().set(opciones).from(elementoParaPDF).save().then(() => {
                // Ocultar elemento después de generar el PDF
                elementoParaPDF.style.display = 'none';
            });
        }

        // Asignar funciones a los botones cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Botón de imprimir
            const btnImprimir = document.getElementById('btnImprimir');
            if (btnImprimir) {
                btnImprimir.onclick = function(e) {
                    e.preventDefault();
                    prepararImpresion();
                };
            }
            
            // Botón de descargar PDF
            const btnDescargarPDF = document.getElementById('btnDescargarPDF');
            if (btnDescargarPDF) {
                btnDescargarPDF.onclick = function(e) {
                    e.preventDefault();
                    generarPDF();
                };
            }
        });
    </script>
</body>
</html>
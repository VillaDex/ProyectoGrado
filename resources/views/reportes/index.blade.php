<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Semanales</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/welcome.css?<?= filemtime(public_path('css/welcome.css')) ?>" />
    <!-- Estilos para impresión y PDF -->
    <style>
        /* Estilos generales consistentes con ventas */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        
        .card-reporte {
            transition: transform 0.3s;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .card-reporte:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .card-header {
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .week-selector {
            margin-bottom: 20px;
        }
        
        .header-container {
            position: relative;
            margin-bottom: 30px;
        }
        
        .btn-volver {
            position: absolute;
            top: 0;
            right: 0;
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        
        /* Estilos específicos para impresión y PDF */
        @media print {
            /* Ocultar elementos que no se necesitan en la impresión */
            .navbar, .sidebar, .btn, .btn-volver, .no-print {
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
            
            /* Pie de página con información de impresión */
            .content:after {
                content: "Fecha de impresión: " attr(data-print-date);
                display: block;
                text-align: center;
                font-size: 10pt;
                color: #7f8c8d;
                margin-top: 30px;
                border-top: 1px solid #e0e0e0;
                padding-top: 10px;
            }
            
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
            
            .card-reporte {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                page-break-inside: avoid;
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
            <li class="nav-item"><a href="{{ route('ventas.index') }}" class="nav-link"><i class="fas fa-cash-register"></i> Ventas</a></li>
            <li class="nav-item"><a href="{{ route('reportes.index') }}" class="nav-link active"><i class="fas fa-file-alt"></i> Reportes</a></li>
        </ul>
    </div>
    
    <div class="content">
        <div class="container mt-4">
            <div class="header-container">
                <h1><i class="fas fa-file-alt me-2"></i>Reportes Semanales</h1>
                
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-reporte">
                        <div class="card-header bg-success text-white">
                            <i class="fas fa-chart-line me-2"></i> Reporte de Ventas
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reportes.ventas.previa') }}" method="GET">
                                <div class="week-selector">
                                    <label for="semana_ventas" class="form-label">Seleccionar Semana:</label>
                                    <select name="semana" id="semana_ventas" class="form-control">
                                        @foreach($semanas as $semana)
                                        <option value="{{ $semana['value'] }}" {{ $semana['selected'] ? 'selected' : '' }}>
                                            {{ $semana['label'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="row d-none">
                                    <div class="col-md-6">
                                        <input type="date" name="fecha_inicio" value="{{ $fechaInicioDefault }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" name="fecha_fin" value="{{ $fechaFinDefault }}">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-eye me-1"></i> Generar Reporte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-reporte">
                        <div class="card-header bg-primary text-white">
                            <i class="fas fa-shopping-cart me-2"></i> Reporte de Compras
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reportes.compras.previa') }}" method="GET">
                                <div class="week-selector">
                                    <label for="semana_compras" class="form-label">Seleccionar Semana:</label>
                                    <select name="semana" id="semana_compras" class="form-control">
                                        @foreach($semanas as $semana)
                                        <option value="{{ $semana['value'] }}" {{ $semana['selected'] ? 'selected' : '' }}>
                                            {{ $semana['label'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="row d-none">
                                    <div class="col-md-6">
                                        <input type="date" name="fecha_inicio" value="{{ $fechaInicioDefault }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" name="fecha_fin" value="{{ $fechaFinDefault }}">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-eye me-1"></i> Generar Reporte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('welcome') }}" class="btn btn-secondary mt-3 no-print"><i class="fas fa-home"></i> Volver al Inicio</a>
        </div>
    </div>
    
    <!-- Elemento oculto para generar el PDF -->
    <div id="reportePDF">
        <div class="pdf-header">
            <div class="pdf-logo">
                <i class="fas fa-box-open"></i> Sistema Inventario
            </div>
            <h2>Reportes Semanales</h2>
            <p class="pdf-date" id="pdfDate">Fecha: </p>
        </div>
        
        <div class="pdf-content" id="pdfContent">
            <!-- El contenido del reporte se generará dinámicamente -->
        </div>
        
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
                <h2>Reportes Semanales</h2>
                <p class="print-date">Fecha: ${fechaFormateada}</p>
            `;
            
            // Insertar al principio del contenido
            let contenido = document.querySelector('.content .container');
            contenido.insertBefore(tituloImpresion, contenido.firstChild);
            
            // Iniciar impresión
            window.print();
            
            // Restaurar elementos después de imprimir
            window.addEventListener('afterprint', function() {
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
            
            // Copiar contenido al elemento PDF
            const pdfContent = document.getElementById('pdfContent');
            pdfContent.innerHTML = '';
            
            // Clonar las tarjetas de reportes (sin botones)
            const cards = document.querySelectorAll('.card-reporte');
            cards.forEach(card => {
                const clonedCard = card.cloneNode(true);
                
                // Eliminar botones y elementos no necesarios
                clonedCard.querySelectorAll('button, .no-print').forEach(el => el.remove());
                
                pdfContent.appendChild(clonedCard);
            });
            
            // Actualizar pie de página
            document.getElementById('pdfFooter').textContent = `Fecha de generación: ${fechaFormateada}`;
            
            // Configurar opciones de html2pdf
            const opciones = {
                margin: [10, 10, 10, 10],
                filename: `Reportes_Semanales_${fechaActual.toISOString().split('T')[0]}.pdf`,
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
            
            // También podemos asignar la generación de PDF si se desea
            // const btnDescargarPDF = document.getElementById('btnDescargarPDF');
            // if (btnDescargarPDF) {
            //     btnDescargarPDF.onclick = function(e) {
            //         e.preventDefault();
            //         generarPDF();
            //     };
            // }
        });
        
        // Manejo de los selectores de fecha (mantenido del original)
        $(document).ready(function() {
            $('select[name="semana"]').change(function() {
                const [fechaInicio, fechaFin] = $(this).val().split('_');
                $(this).closest('form').find('input[name="fecha_inicio"]').val(fechaInicio);
                $(this).closest('form').find('input[name="fecha_fin"]').val(fechaFin);
            });
            
            $('select[name="semana"]').trigger('change');
        });
    </script>
</body>
</html>
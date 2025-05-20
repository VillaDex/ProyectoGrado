<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Políticas de Privacidad - Sistema de Inventario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --accent-color: #ec4899;
            --text-color: #1f2937;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--bg-color) 0%, #ddd6fe 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .bg-element {
            position: absolute;
            opacity: 0.5;
            z-index: 0;
        }

        .circle {
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            filter: blur(15px);
            animation: float 8s infinite alternate ease-in-out;
        }

        .circle-1 {
            width: 150px;
            height: 150px;
            top: -50px;
            left: 10%;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 100px;
            height: 100px;
            bottom: 10%;
            right: 15%;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 70px;
            height: 70px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) scale(1);
            }
            100% {
                transform: translateY(-20px) scale(1.1);
            }
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo i {
            font-size: 28px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 40px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .header {
            margin-bottom: 30px;
            text-align: center;
        }

        h1 {
            font-size: 32px;
            color: var(--text-color);
            margin-bottom: 15px;
        }

        .subtitle {
            font-size: 16px;
            color: #6b7280;
        }

        .divider {
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            width: 100px;
            margin: 20px auto;
            border-radius: 3px;
        }

        .section {
            margin-bottom: 40px;
        }

        h2 {
            font-size: 24px;
            color: var(--text-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        h3 {
            font-size: 20px;
            color: var(--text-color);
            margin: 20px 0 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.7;
            color: #4b5563;
            margin-bottom: 15px;
        }

        ul, ol {
            margin-bottom: 20px;
            padding-left: 25px;
        }

        li {
            margin-bottom: 10px;
            line-height: 1.7;
            color: #4b5563;
        }

        .highlight {
            background-color: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            margin: 20px 0;
        }

        .highlight p {
            margin-bottom: 0;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        }

        .btn-secondary {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: #f3f4f6;
        }

        .footer {
            background-color: #1f2937;
            color: white;
            padding: 40px 20px;
            text-align: center;
            margin-top: 60px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            text-align: left;
        }

        .footer-section h3 {
            color: white;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: white;
        }

        .footer-bottom {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #374151;
            font-size: 14px;
            color: #9ca3af;
        }

        .social-links {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-links a {
            color: white;
            background-color: #374151;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        .toc {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .toc h3 {
            margin-top: 0;
        }

        .toc ul {
            padding-left: 20px;
        }

        .toc li {
            margin-bottom: 8px;
        }

        .toc a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .toc a:hover {
            text-decoration: underline;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            z-index: 100;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .back-to-top i {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <!-- Elementos de fondo animados -->
    <div class="bg-element circle circle-1"></div>
    <div class="bg-element circle circle-2"></div>
    <div class="bg-element circle circle-3"></div>
    
    <!-- Barra de navegación -->
    <nav class="navbar">
        <a href="#" class="logo">
            <i class="fas fa-boxes"></i> Inventario
        </a>
        
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        <div class="header">
            <h1>Políticas de Privacidad</h1>
            <div class="divider"></div>
            <p class="subtitle">Última actualización: 06 de abril de 2025</p>
        
        </div>
<div class="buttons">
    <a href="{{ route('register') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"> <i class="fas fa-user-plus"></i></i> Volver al registro
    </a>
</div>
        <!-- Tabla de contenidos -->
        <div class="toc">
            <h3>Contenido</h3>
            <ul>
                <li><a href="#introduccion">1. Introducción</a></li>
                <li><a href="#recopilacion">2. Información que recopilamos</a></li>
                <li><a href="#uso">3. Uso de la información</a></li>
                <li><a href="#almacenamiento">4. Almacenamiento y seguridad</a></li>
                <li><a href="#compartir">5. Compartir información con terceros</a></li>
                <li><a href="#usuarios">6. Tipos de usuarios y acceso a la información</a></li>
            </ul>
        </div>

        <!-- Secciones de la política de privacidad -->
        <div class="section" id="introduccion">
            <h2>1. Introducción</h2>
            <p>Bienvenido a las Políticas de Privacidad de nuestro Sistema de Gestión de Inventario. Este documento está diseñado para informarte sobre cómo recopilamos, utilizamos, almacenamos y protegemos tu información personal cuando utilizas nuestra plataforma.</p>
            <p>Entendemos la importancia de la privacidad de tus datos y nos comprometemos a protegerlos de acuerdo con las leyes y regulaciones aplicables sobre protección de datos. Estas políticas explican tus derechos respecto a tus datos personales y las prácticas que seguimos para mantener la seguridad de tu información.</p>
            
            <div class="highlight">
                <p><strong>Nota importante:</strong> Al registrarte y utilizar nuestro sistema de inventario, aceptas las prácticas descritas en esta política de privacidad. Te recomendamos leer atentamente este documento para entender cómo se tratarán tus datos personales.</p>
            </div>
        </div>

        <div class="section" id="recopilacion">
            <h2>2. Información que recopilamos</h2>
            <p>Dependiendo de tu rol en el sistema (usuario regular, administrador o proveedor), podemos recopilar diferentes tipos de información:</p>
            
            <h3>2.1 Información de registro</h3>
            <ul>
                <li><strong>Datos personales básicos:</strong> Nombre completo, dirección de correo electrónico, nombre de usuario y contraseña encriptada.</li>
                <li><strong>Información de contacto:</strong> Número de teléfono, dirección postal y otros datos de contacto que decidas proporcionar.</li>
                <li><strong>Información de perfil:</strong> Foto de perfil, descripción, preferencias y configuraciones que establezcas en tu cuenta.</li>
            </ul>
            
            <h3>2.2 Información de transacciones</h3>
            <ul>
                <li><strong>Historial de compras:</strong> Productos adquiridos, fechas, cantidades, precios y métodos de pago utilizados.</li>
                <li><strong>Información de ventas:</strong> Detalles de ventas realizadas, incluyendo productos, cantidades, precios y clientes (para administradores y proveedores).</li>
                <li><strong>Información de inventario:</strong> Datos relacionados con el seguimiento y gestión de productos.</li>
            </ul>
        </div>

        <div class="section" id="uso">
            <h2>3. Uso de la información</h2>
            <p>Utilizamos la información recopilada para los siguientes propósitos:</p>
            
            <h3>3.1 Proporcionar y mejorar nuestros servicios</h3>
            <ul>
                <li>Gestionar tu cuenta y brindarte acceso a las funcionalidades del sistema según tu perfil de usuario.</li>
                <li>Procesar y mantener un registro de tus transacciones (compras, ventas, movimientos de inventario).</li>
                <li>Personalizar tu experiencia y mostrarte información relevante, como recomendaciones de productos o alertas de stock bajo.</li>
                <li>Mejorar y optimizar nuestro sistema, desarrollar nuevas características y analizar patrones de uso.</li>
            </ul>
            
            <h3>3.2 Comunicación</h3>
            <ul>
                <li>Proporcionarte actualizaciones sobre el estado de tus pedidos, disponibilidad de productos o cambios en el inventario.</li>
                   </ul>
            
            <h3>3.3 Uso del agente inteligente</h3>
            <p>Nuestro sistema incluye un agente inteligente que utiliza datos para:</p>
            <ul>
                <li>Identificar y mostrarte los productos más vendidos basados en el análisis de tendencias de compra.</li>
                <li>Alertarte sobre productos con bajo stock para facilitar la gestión de inventario.</li>
                <li>Proporcionar recomendaciones personalizadas basadas en el historial de todos nuestros clientes, de compras y preferencias.</li>
                <li>Generar informes y análisis estadísticos para mejorar la gestión del inventario y las ventas.</li>
            </ul>
            
            <div class="highlight">
                <p><strong>Importante:</strong> Los datos utilizados por nuestro agente inteligente son procesados con técnicas de anonimización cuando se emplean para análisis globales, protegiendo así la privacidad de los usuarios individuales.</p>
            </div>
        </div>

        <div class="section" id="almacenamiento">
            <h2>4. Almacenamiento y seguridad</h2>
            <p>Nos comprometemos a proteger la seguridad de tu información personal mediante la implementación de medidas técnicas y organizativas apropiadas:</p>
            
            <h3>4.1 Medidas de seguridad</h3>
            <ul>
                <li>Encriptación de datos sensibles, especialmente contraseñas.</li>
                <li>Protocolos de acceso restringido para el personal autorizado según el principio de necesidad de conocimiento.</li>
                <li>Sistemas de detección y prevención de intrusiones para proteger contra accesos no autorizados.</li>
            </ul>
            
                    </div>

        <div class="section" id="compartir">
            <h2>5. Compartir información con terceros</h2>
            <p>No vendemos ni alquilamos tu información personal a terceros. Sin embargo, podemos compartir cierta información en las siguientes circunstancias:</p>
            
           
            <h3>5.1 Compartir información según tu rol de usuario</h3>
            <p>Dependiendo de tu rol en el sistema, cierta información puede ser visible para otros usuarios:</p>
            <ul>
                <li><strong>Administradores:</strong> Tienen acceso a datos de clientes, proveedores, productos y movimientos de compra y venta para gestionar el sistema.</li>
                <li><strong>Proveedores:</strong> Pueden ver información sobre productos, listado de clientes y movimientos de compra y venta relacionados con sus productos.</li>
                <li><strong>Usuarios regulares:</strong> Pueden ver información de productos, disponibilidad de stock y sus propios historiales de compra.</li>
            </ul>
           
        </div>

        

        <div class="section" id="usuarios">
            <h2>6. Tipos de usuarios y acceso a la información</h2>
            <p>Nuestro sistema distingue entre diferentes tipos de usuarios, cada uno con diferentes niveles de acceso a la información:</p>
            
            <h3>6.1 Usuarios regulares</h3>
            <p>Los usuarios regulares pueden:</p>
            <ul>
                <li>Ver catálogos de productos y su disponibilidad en stock.</li>
                <li>Realizar compras y consultar su historial de compras personal.</li>
                <li>Recibir recomendaciones personalizadas y alertas del agente inteligente sobre productos populares o con bajo stock.</li>
                <li>Gestionar su perfil y preferencias personales.</li>
            </ul>
            <p>Los usuarios regulares no tienen acceso a datos de otros clientes, información detallada de proveedores, ni pueden ver información financiera.</p>
            
            <h3>6.2 Administradores</h3>
            <p>Los administradores tienen acceso amplio al sistema, incluyendo:</p>
            <ul>
                <li>Datos de todos los clientes, incluyendo perfiles, historiales de compra y preferencias.</li>
                <li>Información completa sobre proveedores y sus productos.</li>
                <li>Datos detallados de inventario, incluyendo movimientos de stock, valoraciones y ajustes.</li>
                <li>Registros completos de todas las transacciones de compra y venta.</li>
                <li>Informes y análisis de la Gestión del inventario.</li>
            </ul>
            <p>Los administradores están sujetos a estrictas políticas de confidencialidad y uso adecuado de la información, con obligación de respetar la privacidad de clientes y proveedores.</p>
            
            <h3>6.3 Proveedores</h3>
            <p>Los proveedores tienen un acceso intermedio que incluye:</p>
            <ul>
                <li>Información básica sobre los productos disponibles en el sistema.</li>
                <li>Lista general de clientes (sin datos personales detallados).</li>
                <li>Registros de movimientos de compra y venta relacionados con sus productos.</li>
            </ul>
            <p>Los proveedores no pueden acceder a información sensible de clientes, datos financieros detallados del negocio ni a información estratégica confidencial.</p>
        
            <div class="buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"> <i class="fas fa-user-plus"></i></i> Volver al registro
                </a>
            </div>
        </div>

        
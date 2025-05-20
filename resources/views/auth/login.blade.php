<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Inventario</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--bg-color) 0%, #ddd6fe 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated background elements */
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

        .login-container {
            display: flex;
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            width: 850px;
            height: 550px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 1;
            position: relative;
        }

        .login-form {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-image {
            flex: 1;
            background: url('/api/placeholder/425/550') center/cover;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(79, 70, 229, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .login-logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-logo i {
            font-size: 28px;
        }

        h2 {
            font-size: 28px;
            color: var(--text-color);
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 30px;
        }

        .error-message {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 15px;
            color: #9ca3af;
        }

        input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #f9fafb;
            color: var(--text-color);
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            background-color: white;
        }

        input::placeholder {
            color: #9ca3af;
        }

        .forgot-password {
            font-size: 14px;
            text-align: right;
            margin-bottom: 24px;
        }

        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .btn {
            display: inline-block;
            padding: 14px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-align: center;
            width: 100%;
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

        .register-option {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #6b7280;
        }

        .register-option a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-option a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            color: #9ca3af;
            font-size: 14px;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #e5e7eb;
        }

        .divider::before {
            margin-right: 15px;
        }

        .divider::after {
            margin-left: 15px;
        }

        .social-login {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
            background-color: white;
            color: var(--text-color);
        }

        .social-btn:hover {
            background-color: #f9fafb;
            transform: translateY(-2px);
        }

        /* Animated shape in logo */
        .logo-shape {
            width: 10px;
            height: 10px;
            background-color: var(--accent-color);
            border-radius: 50%;
            margin-left: 5px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.5);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive design */
        @media (max-width: 900px) {
            .login-container {
                width: 95%;
                height: auto;
                flex-direction: column;
            }

            .login-image {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Background elements -->
    <div class="bg-element circle circle-1"></div>
    <div class="bg-element circle circle-2"></div>
    <div class="bg-element circle circle-3"></div>

    <div class="login-container">
        <div class="login-form">
            <div class="login-logo">
                <i class="fas fa-boxes"></i> 
                Inventario
                <div class="logo-shape"></div>
            </div>

            <h2>Bienvenido de nuevo</h2>
            <p class="subtitle">Accede a tu sistema de inventario</p>

            @if (session('error'))
    <div class="error-message">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif


            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>

                <div class="forgot-password">
                    <a href="{{ route('password.verify.form') }}">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn btn-primary">
                    Iniciar Sesión <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                </button>
            </form>


            <div class="register-option">
                ¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate ahora</a>
            </div>
        </div>

        <div class="login-image">
            <div class="overlay">
                <h2 style="color: white; margin-bottom: 20px;">Sistema de Inventario</h2>
                <p>Gestiona tu inventario de manera eficiente y mantén el control de tus productos en tiempo real.</p>
            </div>
        </div>
    </div>

    <script>
        // Display error message if session has an error
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const hasError = urlParams.get('error');
            
            if (hasError) {
                document.querySelector('.error-message').style.display = 'flex';
            }
            
            // Animation for form inputs
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-5px)';
                    this.parentElement.style.transition = 'transform 0.3s ease';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
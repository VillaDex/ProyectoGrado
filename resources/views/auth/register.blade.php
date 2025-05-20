<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Sistema de Inventario</title>
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

        .register-container {
            display: flex;
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            width: 850px;
            height: 600px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 1;
            position: relative;
        }

        .register-form {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .register-image {
            flex: 1;
            background: url('/api/placeholder/425/600') center/cover;
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

        .register-logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .register-logo i {
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
            display: none;
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

        .password-strength {
            margin-top: -10px;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .strength-meter {
            height: 5px;
            border-radius: 3px;
            background: #e5e7eb;
            margin-bottom: 5px;
            overflow: hidden;
        }

        .strength-meter div {
            height: 100%;
            width: 0;
            transition: width 0.3s ease;
        }

        .strength-text {
            display: flex;
            justify-content: space-between;
            color: #6b7280;
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

        .login-option {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #6b7280;
        }

        .login-option a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-option a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .terms {
            font-size: 13px;
            color: #6b7280;
            margin-top: 20px;
            text-align: center;
        }

        .terms a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .terms-checkbox {
            margin: 15px 0;
            display: flex;
            align-items: center;
        }

        .terms-checkbox input {
            margin-right: 10px;
        }

        .terms-checkbox label {
            font-size: 14px;
            color: #6b7280;
        }

        .terms-checkbox a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .register-container {
                width: 95%;
                height: auto;
                flex-direction: column;
            }

            .register-image {
                height: 200px;
            }
        }


        /* Tus estilos actuales aquí */

        /* Estilos adicionales para los checkboxes */
        .terms-checkbox {
            margin: 15px 0;
            display: flex;
            align-items: center;
        }

        .terms-checkbox input[type="checkbox"] {
            margin-right: 10px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .terms-checkbox label {
            font-size: 14px;
            color: #6b7280;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .terms-checkbox a {
            color: var(--primary-color);
            text-decoration: none;
            margin-left: 5px;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-form">
            <div class="register-logo">
                <i class="fas fa-boxes"></i> 
                Inventario
                <div class="logo-shape"></div>
            </div>

            <h2>Crea tu cuenta</h2>

            <!-- Error message -->
            <div class="error-message" id="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <span id="error-text">Hubo un error. Por favor, revisa los datos ingresados.</span>
            </div>

            <form method="POST" action="{{ route('register.attempt') }}" id="register-form">
                @csrf
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Nombre completo" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                </div>
                
                <div class="password-strength">
                    <div class="strength-meter">
                        <div id="strength-bar"></div>
                    </div>
                    <div class="strength-text">
                        <span>Débil</span>
                        <span>Media</span>
                        <span>Fuerte</span>
                    </div>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                </div>

                <!-- Checkbox para aceptar términos y condiciones -->
                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">Acepto los <a href="/terminos-y-condiciones">Términos y Condiciones</a></label>
                </div>

                <!-- Checkbox para permitir el tratamiento de datos -->
                <div class="terms-checkbox">
                    <input type="checkbox" id="data-processing" name="data-processing" required>
                    <label for="data-processing">Permito el tratamiento de mis datos personales</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Crear cuenta <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                </button>
                
                <div class="terms">
                    Al registrarte, aceptas nuestros <a href="#">Términos de servicio</a> y <a href="#">Políticas de privacidad</a>
                </div>
            </form>

            <div class="login-option">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
            </div>
        </div>

        <div class="register-image">
            <div class="overlay">
                <h2 style="color: white; margin-bottom: 20px;">Beneficios de InventarioX</h2>
                <ul style="text-align: left; margin-bottom: 20px;">
                    <li style="margin-bottom: 10px;">✓ Control en tiempo real de tus productos</li>
                    <li style="margin-bottom: 10px;">✓ Alertas automáticas de stock bajo</li>
                    <li style="margin-bottom: 10px;">✓ Informes detallados y personalizables</li>
                    <li style="margin-bottom: 10px;">✓ Acceso desde cualquier dispositivo</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Validación del formulario antes de enviar
        document.getElementById('register-form').addEventListener('submit', function(event) {
            const termsCheckbox = document.getElementById('terms');
            const dataProcessingCheckbox = document.getElementById('data-processing');
            const errorMessage = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            if (!termsCheckbox.checked || !dataProcessingCheckbox.checked) {
                event.preventDefault(); // Evita que el formulario se envíe
                errorText.textContent = "Debes aceptar los términos y condiciones y permitir el tratamiento de datos para registrarte.";
                errorMessage.style.display = 'flex'; // Muestra el mensaje de error
            } else {
                errorMessage.style.display = 'none'; // Oculta el mensaje de error si todo está bien
            }
        });

        // Handling password strength indicator
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('strength-bar');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Calculate password strength
                if (password.length >= 8) strength += 10;
                if (password.match(/[a-z]+/)) strength += 10;
                if (password.match(/[A-Z]+/)) strength += 10;
                if (password.match(/[0-9]+/)) strength += 10;
                
                // Update the strength bar
                strengthBar.style.width = strength + '%';
                
                // Change color based on strength
                if (strength < 50) {
                    strengthBar.style.backgroundColor = '#ef4444';
                } else if (strength < 75) {
                    strengthBar.style.backgroundColor = '#f59e0b';
                } else {
                    strengthBar.style.backgroundColor = '#10b981';
                }
            });
            
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
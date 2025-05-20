<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Usuario - Sistema de Inventario</title>
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

        .register-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 33%;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e5e7eb;
            color: #6b7280;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            margin-bottom: 5px;
            position: relative;
        }

        .step-number::after {
            content: '';
            position: absolute;
            height: 2px;
            background-color: #e5e7eb;
            width: 100%;
            top: 50%;
            left: 100%;
            transform: translateY(-50%);
        }

        .step:last-child .step-number::after {
            display: none;
        }

        .step.active .step-number {
            background-color: var(--primary-color);
            color: white;
        }

        .step-text {
            font-size: 12px;
            color: #6b7280;
        }

        .step.active .step-text {
            color: var(--primary-color);
            font-weight: 600;
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

            <h2>Verificar Usuario</h2>

            @if ($errors->has('verify'))
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first('verify') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify') }}">
                @csrf
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Nombre completo" value="{{ old('name') }}" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Verificar <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                </button>
            </form>

            <div class="login-option">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar sesión</a>
            </div>
        </div>

        <div class="register-image">
            <div class="overlay">
                <h2 style="color: white; margin-bottom: 20px;">Para verificar que ya eres un usuario registrado, Necesitamos:</h2>
                <ul style="text-align: left; margin-bottom: 20px;">
                    <li style="margin-bottom: 50px;">Nombre y Correo eléctronico con el que te registraste</li>
            </div>
        </div>
    </div>
</body>
</html>

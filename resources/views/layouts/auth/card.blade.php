<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /* =========================================
           CONFIGURACIÓN GENERAL
        ========================================= */

        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: #020b16;
            color: #ffffff;
        }

        /* =========================================
           PANTALLA PRINCIPAL
        ========================================= */

        .login-screen {
            min-height: 100vh;
            min-height: 100dvh;

            display: flex;
            justify-content: flex-end;
            align-items: center;

            padding: 40px 8%;

            background:
                linear-gradient(
                    90deg,
                    rgba(0, 8, 20, 0.12),
                    rgba(0, 8, 20, 0.25)
                ),
                url("{{ asset('img/FONDO.png') }}")
                center center / cover no-repeat;
        }

        /* =========================================
           PANEL DE INICIO DE SESIÓN
        ========================================= */

        .login-panel {
            width: 100%;
            max-width: 440px;
            padding: 32px;

            background: rgba(2, 13, 27, 0.94);

            border: 1px solid #009dff;
            border-radius: 18px;

            box-shadow:
                0 0 30px rgba(0, 145, 255, 0.12);

            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .login-content {
            width: 100%;
            min-width: 0;
        }

        /* =========================================
           LOGOTIPO Y NOMBRE DE LA EMPRESA
        ========================================= */

        .login-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-bottom: 22px;
        }

        .login-logo {
            width: 92px;
            height: 92px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .login-brand-text {
            min-width: 0;
        }

        .login-brand-text h1 {
            margin: 0;
            color: #dcecff;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.3;
        }

        .login-brand-text span {
            display: block;
            margin-top: 6px;
            color: #00aeff;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 3px;
        }

        /* =========================================
           DESCRIPCIÓN DEL SISTEMA
        ========================================= */

        .login-description {
            margin: 0 0 26px;
            text-align: center;
            color: #a9bfd7;
            font-size: 14px;
            line-height: 1.7;
        }

        /* =========================================
           FORMULARIO
        ========================================= */

        .login-form {
            width: 100%;
        }

        .login-field-group {
            width: 100%;
            min-width: 0;
        }

        /* Etiquetas de correo y contraseña */
        .login-form label {
            color: #e2e8f0;
        }

        /*
         * Flux puede colocar el borde y el fondo
         * en un contenedor interno del componente.
         * Por eso aplicamos los estilos al input
         * y a los contenedores habituales.
         */

        .login-field input {
            background-color: #101827 !important;
            color: #f8fafc !important;
            border: 1px solid #334155 !important;
            border-radius: 10px !important;

            transition:
                border-color 0.25s ease,
                box-shadow 0.25s ease,
                background-color 0.25s ease;
        }

        /* Contenedores de los campos */
        .login-field [data-flux-control],
        .login-field [data-flux-input] {
            background-color: #101827 !important;
            border-color: #334155 !important;
            border-radius: 10px !important;

            transition:
                border-color 0.25s ease,
                box-shadow 0.25s ease,
                background-color 0.25s ease;
        }

        /* Texto de ayuda dentro de los campos */
        .login-field input::placeholder {
            color: #94a3b8 !important;
            opacity: 1;
        }

        /* Estado de selección del campo */
        .login-field input:focus {
            background-color: #111c2e !important;
            border-color: #3b82f6 !important;

            box-shadow:
                0 0 0 3px rgba(59, 130, 246, 0.20) !important;

            outline: none !important;
        }

        /* Resaltar también el contenedor al enfocar */
        .login-field:focus-within [data-flux-control],
        .login-field:focus-within [data-flux-input] {
            border-color: #3b82f6 !important;

            box-shadow:
                0 0 0 3px rgba(59, 130, 246, 0.20) !important;
        }

        /* Texto introducido por el usuario */
        .login-field input:-webkit-autofill,
        .login-field input:-webkit-autofill:hover,
        .login-field input:-webkit-autofill:focus {
            -webkit-text-fill-color: #f8fafc !important;

            transition:
                background-color 9999s ease-in-out 0s;
        }

        /* Iconos de correo y contraseña */
        .login-field svg {
            color: #60a5fa;
            transition: color 0.25s ease;
        }

        .login-field:focus-within svg {
            color: #93c5fd;
        }

        /* =========================================
           ENLACES DEL FORMULARIO
        ========================================= */

        .login-panel a {
            color: #60a5fa;

            transition:
                color 0.2s ease,
                opacity 0.2s ease;
        }

        .login-panel a:hover {
            color: #93c5fd;
        }

        /* =========================================
           BOTÓN INICIAR SESIÓN
        ========================================= */

        .login-button {
            width: 100%;
            min-height: 46px;

            background: linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            ) !important;

            color: #ffffff !important;
            border: 1px solid #3b82f6 !important;
            border-radius: 10px !important;

            font-weight: 600 !important;

            box-shadow:
                0 4px 14px rgba(37, 99, 235, 0.20);

            transition:
                background 0.25s ease,
                box-shadow 0.25s ease,
                transform 0.25s ease;
        }

        /* Efecto al pasar el cursor */
        .login-button:hover {
            background: linear-gradient(
                135deg,
                #3b82f6,
                #2563eb
            ) !important;

            box-shadow:
                0 6px 20px rgba(37, 99, 235, 0.35);

            transform: translateY(-1px);
        }

        /* Efecto al pulsar */
        .login-button:active {
            transform: translateY(0);

            box-shadow:
                0 2px 8px rgba(37, 99, 235, 0.25);
        }

        /* Accesibilidad con teclado */
        .login-button:focus-visible {
            outline: 2px solid #93c5fd;
            outline-offset: 3px;
        }

        /* =========================================
           PIE DEL PANEL
        ========================================= */

        .login-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;

            margin-top: 28px;
            padding-top: 18px;

            border-top: 1px solid #007acb;

            color: #a9bfd7;
            font-size: 11px;
            text-align: center;
        }

        .login-footer strong {
            color: #ffffff;
        }

        .login-footer-divider {
            color: #00aeff;
        }

        /* =========================================
           TABLETS Y PANTALLAS MEDIANAS
        ========================================= */

        @media (max-width: 1024px) {
            .login-screen {
                padding: 32px 5%;
            }

            .login-panel {
                max-width: 420px;
                padding: 28px;
            }

            .login-logo {
                width: 80px;
                height: 80px;
            }

            .login-brand-text h1 {
                font-size: 18px;
            }

            .login-brand-text span {
                font-size: 11px;
                letter-spacing: 2px;
            }
        }

        /* =========================================
           CELULARES Y TABLETS PEQUEÑAS
        ========================================= */

        @media (max-width: 768px) {
            .login-screen {
                justify-content: center;
                align-items: center;

                min-height: 100vh;
                min-height: 100dvh;

                padding: 24px 16px;
                background-position: center center;
            }

            .login-panel {
                width: 100%;
                max-width: 440px;
                padding: 24px 20px;
            }

            .login-brand {
                gap: 12px;
                margin-bottom: 20px;
            }

            .login-logo {
                width: 72px;
                height: 72px;
            }

            .login-brand-text h1 {
                font-size: 16px;
            }

            .login-brand-text span {
                font-size: 10px;
                letter-spacing: 2px;
            }

            .login-description {
                margin-bottom: 22px;
                font-size: 13px;
            }

            .login-footer {
                gap: 7px;
                margin-top: 24px;
                padding-top: 16px;
                font-size: 10px;
            }
        }

        /* =========================================
           CELULARES PEQUEÑOS
        ========================================= */

        @media (max-width: 480px) {
            .login-screen {
                justify-content: center;
                padding: 20px 12px;
                background-position: center center;
            }

            .login-panel {
                padding: 24px 18px;
                border-radius: 14px;
            }

            .login-brand {
                gap: 10px;
                margin-bottom: 20px;
            }

            .login-logo {
                width: 64px;
                height: 64px;
            }

            .login-brand-text h1 {
                font-size: 14px;
            }

            .login-brand-text span {
                font-size: 9px;
                letter-spacing: 1.5px;
            }

            .login-description {
                font-size: 13px;
                line-height: 1.6;
            }

            .login-footer {
                flex-direction: column;
                gap: 6px;
            }

            .login-footer-divider {
                display: none;
            }

            .login-field input {
                font-size: 16px;
            }

            .login-button {
                min-height: 48px;
            }
        }

        /* =========================================
           CELULARES MUY PEQUEÑOS
        ========================================= */

        @media (max-width: 380px) {
            .login-screen {
                padding: 16px 10px;
            }

            .login-panel {
                padding: 20px 14px;
            }

            .login-brand {
                gap: 8px;
            }

            .login-logo {
                width: 56px;
                height: 56px;
            }

            .login-brand-text h1 {
                font-size: 12px;
            }

            .login-brand-text span {
                font-size: 8px;
                letter-spacing: 1px;
            }
        }

        /* =========================================
           PANTALLAS CON POCA ALTURA
        ========================================= */

        @media (max-height: 650px) and (min-width: 769px) {
            .login-screen {
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .login-panel {
                padding: 24px;
            }

            .login-logo {
                width: 72px;
                height: 72px;
            }

            .login-brand {
                margin-bottom: 16px;
            }

            .login-description {
                margin-bottom: 18px;
            }

            .login-footer {
                margin-top: 20px;
                padding-top: 12px;
            }
        }

        /* =========================================
           REDUCIR ANIMACIONES
        ========================================= */

        @media (prefers-reduced-motion: reduce) {
            .login-panel a,
            .login-field input,
            .login-field svg,
            .login-button {
                transition: none !important;
            }

            .login-button:hover {
                transform: none;
            }
        }
    </style>
</head>

<body>
    <main class="login-screen">

        <section class="login-panel">
            {{ $slot }}
        </section>

    </main>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>403 | Acceso denegado - THE GAME SRL</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            min-height: 100dvh;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #020b16;
            background-image:
                linear-gradient(
                    rgba(2, 11, 22, 0.10),
                    rgba(2, 11, 22, 0.20)
                ),
                url("{{ asset('img/FONDO_403.png') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 18px;
        }

        .page {
            width: 100%;
            max-width: 520px;
            text-align: center;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 40px;
        }

        .brand img {
            width: 58px;
            height: 58px;
            object-fit: contain;
        }

        .brand-text {
            text-align: left;
        }

        .brand-text h1 {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 0.3px;
        }

        .brand-text p {
            margin-top: 5px;
            color: #60a5fa;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .error-card {
            padding: 42px 34px;
            background: rgba(9, 20, 41, 0.88);
            border: 1px solid rgba(59, 130, 246, 0.35);
            border-radius: 17px;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.30),
                0 0 30px rgba(37, 99, 235, 0.06);
        }

        .shield {
            width: 76px;
            height: 76px;
            margin: 0 auto 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.35);
            color: #38bdf8;
        }

        .error-code {
            font-size: 74px;
            font-weight: 800;
            line-height: 1.1;
            color: #60a5fa;
            letter-spacing: -2px;
        }

        .error-title {
            font-size: 23px;
            font-weight: 750;
            margin: 10px 0 18px;
        }

        .error-message {
            color: #dbeafe;
            font-size: 15px;
            line-height: 1.7;
        }

        .error-help {
            color: #93b4dc;
            font-size: 13px;
            line-height: 1.6;
            margin-top: 14px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-width: 165px;
            margin-top: 30px;
            padding: 13px 28px;
            border-radius: 9px;
            background: linear-gradient(
                135deg, #2563eb, #0284c7
            );
            border: 1px solid rgba(96, 165, 250, 0.5);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.7px;
            transition: background 0.2s,
                        transform 0.2s,
                        box-shadow 0.2s;
        }

        .btn-back:hover {
            background: linear-gradient(
                135deg, #1d4ed8, #0369a1
            );
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        }

        .btn-back:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 4px;
        }

        .footer {
            margin-top: 30px;
            color: #7891b2;
            font-size: 11px;
            line-height: 1.6;
        }

        @media (max-width: 480px) {
            .brand {
                gap: 10px;
            }

            .brand img {
                width: 48px;
                height: 48px;
            }

            .brand-text h1 {
                font-size: 13px;
            }

            .error-card {
                padding: 34px 20px;
            }

            .error-code {
                font-size: 64px;
            }

            .error-title {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

    <main class="page">

        <!-- Encabezado THE GAME -->
        <header class="brand">
            <img
                src="{{ asset('img/LOGO THE GAME.png') }}"
                alt="Logo THE GAME SRL"
            >

            <div class="brand-text">
                <h1>SISTEMA DE INVENTARIO</h1>
                <p>THE GAME SRL</p>
            </div>
        </header>

        <!-- Tarjeta de error -->
        <section class="error-card"
                 aria-labelledby="error-title">

            <div class="shield">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="38"
                     height="38"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="M12 8v5"/>
                    <path d="M12 17h.01"/>
                </svg>
            </div>

            <div class="error-code">403</div>

            <h2 class="error-title" id="error-title">
                Acceso denegado
            </h2>

            <p class="error-message">
                No tienes los permisos necesarios
                para acceder a esta sección del sistema.
            </p>

            <p class="error-help">
                Si necesitas acceso, comunícate
                con el administrador.
            </p>

            <!-- Único botón ATRÁS -->
            <a href="{{ url('/') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="18"
                     height="18"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="m12 19-7-7 7-7"/>
                    <path d="M19 12H5"/>
                </svg>

                ATRÁS
            </a>

        </section>

        <!-- Pie de página -->
        <footer class="footer">
            © {{ date('Y') }} THE GAME SRL.
            Todos los derechos reservados.
        </footer>

    </main>

</body>
</html>

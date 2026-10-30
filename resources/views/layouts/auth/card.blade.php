<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: #020b16;
            color: #fff;
        }

        .login-screen {
            min-height: 100vh;
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

        .login-panel {
            width: 100%;
            max-width: 440px;
            padding: 32px;
            background: rgba(2, 13, 27, 0.94);
            border: 1px solid #009dff;
            border-radius: 18px;
            box-shadow: 0 0 30px rgba(0, 145, 255, 0.12);
            backdrop-filter: blur(8px);
        }

        .login-content {
            width: 100%;
        }

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

        .login-description {
            margin: 0 0 26px;
            text-align: center;
            color: #a9bfd7;
            font-size: 14px;
            line-height: 1.7;
        }

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
            color: #fff;
        }

        .login-footer-divider {
            color: #00aeff;
        }

        @media (max-width: 768px) {
            .login-screen {
                justify-content: center;
                padding: 24px 16px;
                background-position: center;
            }

            .login-panel {
                max-width: 440px;
                padding: 24px 20px;
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
        }

        @media (max-width: 380px) {
            .login-brand {
                gap: 8px;
            }

            .login-logo {
                width: 60px;
                height: 60px;
            }

            .login-brand-text h1 {
                font-size: 14px;
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

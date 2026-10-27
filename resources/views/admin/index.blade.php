<x-layouts.app :title="'Sistema de Prestamos y Cobranzas - Admin'">

    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">Bienvenido al Sistema</flux:heading>
            <flux:text class="mt-2 text-gray-600 dark:text-gray-400">
                Resumen general del sistema de préstamos y cobranzas
            </flux:text>
        </div>
        <div class="text-right">
            <flux:text class="text-blue-600 dark:text-white text-sm font-medium">
                <i class="fas fa-user-shield mr-1"></i>
                Rol del Usuario
            </flux:text>
            <b class="text-blue-600 dark:text-white">
                <i class="fas fa-id-badge mr-1"></i>
                {{ Auth::user()->roles->pluck('name')->implode(', ') }}
            </b>
        </div>
    </div>

    <flux:separator variant="subtle" />

    <br>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        @can('Ver listado de roles')
            <!-- Total Roles -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3
                shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Roles</flux:text>
                        <flux:heading size="lg" level="3" class="mt-2 text-gray-900 dark:text-white">
                            {{ $total_roles ?? 0 }}</flux:heading>
                        <flux:text class="text-green-600 dark:text-green-400 text-xs mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>{{ $rolesNuevosMes ?? 0 }} nuevos este mes
                        </flux:text>
                    </div>
                    <div class="p-3  dark:bg-green-900/30 rounded-lg">
                        <i class="fas fa-shield-alt text-green-600 dark:text-green-400 text-2xl"></i>
                    </div>
                </div>
                <div class="h-12" style="margin-top:-25px">
                    <canvas id="chartRoles" class="w-full block" height="48"></canvas>
                </div>
            </div>
        @endcan

        @can('Ver listado de usuarios')
            <!-- Total Usuarios -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3
                shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Usuarios</flux:text>
                        <flux:heading size="lg" level="3" class="mt-2 text-gray-900 dark:text-white">
                            {{ $totalUsuarios ?? 0 }}</flux:heading>
                        <flux:text class="text-violet-600 dark:text-violet-400 text-xs mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>{{ $usuariosNuevosMes ?? 0 }} nuevos este mes
                        </flux:text>
                    </div>
                    <div class="p-3  dark:bg-violet-900/30 rounded-lg">
                        <i class="fas fa-users text-violet-600 dark:text-violet-400 text-2xl"></i>
                    </div>
                </div>
                <div class="h-12" style="margin-top:-25px">
                    <canvas id="chartUsuarios" class="w-full block" height="48"></canvas>
                </div>
            </div>
        @endcan

        @can('Ver listado de clientes')
            <!-- Total Clientes -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3
                shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Clientes</flux:text>
                        <flux:heading size="lg" level="3" class="mt-2 text-gray-900 dark:text-white">
                            {{ $totalClientes ?? 0 }}</flux:heading>
                        <flux:text class="text-blue-600 dark:text-blue-400 text-xs mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>{{ $clientesNuevosMes ?? 0 }} nuevos este mes
                        </flux:text>
                    </div>
                    <div class="p-3  dark:bg-blue-900/30 rounded-lg">
                        <i class="fas fa-users text-blue-600 dark:text-blue-400 text-2xl"></i>
                    </div>
                </div>
                <div class="h-12" style="margin-top:-25px">
                    <canvas id="chartClientes" class="w-full block" height="48"></canvas>
                </div>
            </div>
        @endcan

        @can('Ver listado de categorias')
            <!-- Total Categorias -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3
                shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Categorias</flux:text>
                        <flux:heading size="lg" level="3" class="mt-2 text-gray-900 dark:text-white">
                            {{ $totalCategorias ?? 0 }}</flux:heading>
                        <flux:text class="text-amber-600 dark:text-amber-400 text-xs mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>{{ $categoriasNuevasMes ?? 0 }} nuevas este mes
                        </flux:text>
                    </div>
                    <div class="p-3  dark:bg-amber-900/30 rounded-lg">
                        <i class="fas fa-tags text-amber-600 dark:text-amber-400 text-2xl"></i>
                    </div>
                </div>
                <div class="h-12" style="margin-top:-25px">
                    <canvas id="chartCategorias" class="w-full block" height="48"></canvas>
                </div>
            </div>
        @endcan

        @can('Ver listado de prestamos')
            <!-- Total Prestamos -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3
                shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Prestamos</flux:text>
                        <flux:heading size="lg" level="3" class="mt-2 text-gray-900 dark:text-white">
                            {{ $totalPrestamos ?? 0 }}</flux:heading>
                        <flux:text class="text-rose-600 dark:text-rose-400 text-xs mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>{{ $prestamosNuevosMes ?? 0 }} nuevos este mes
                        </flux:text>
                    </div>
                    <div class="p-3  dark:bg-rose-900/30 rounded-lg">
                        <i class="fas fa-file-invoice-dollar text-rose-600 dark:text-rose-400 text-2xl"></i>
                    </div>
                </div>
                <div class="h-12" style="margin-top:-25px">
                    <canvas id="chartPrestamos" class="w-full block" height="48"></canvas>
                </div>
            </div>
        @endcan

        @can('Ver listado de prestamos')
            <!-- Prestamos Activos -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3
                shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-sm font-medium">Prestamos Activos</flux:text>
                        <flux:heading size="lg" level="3" class="mt-2 text-gray-900 dark:text-white">
                            {{ $totalPrestamosActivos ?? 0 }}</flux:heading>
                        <flux:text class="text-cyan-600 dark:text-cyan-400 text-xs mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>{{ $prestamosActivosMes ?? 0 }} nuevos este mes
                        </flux:text>
                    </div>
                    <div class="p-3  dark:bg-cyan-900/30 rounded-lg">
                        <i class="fas fa-hand-holding-dollar text-cyan-600 dark:text-cyan-400 text-2xl"></i>
                    </div>
                </div>
                <div class="h-12" style="margin-top:-25px">
                    <canvas id="chartPrestamosActivos" class="w-full block" height="48"></canvas>
                </div>
            </div>
        @endcan

        @can('Ver listado de notificaciones')
            <!-- Notificaciones de Atrasos -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3
                shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-sm font-medium">Clientes Con Atrasos</flux:text>
                        <flux:heading size="lg" level="3" class="mt-2 text-gray-900 dark:text-white">
                            {{ $clientesConCuotasVencidas ?? 0 }}</flux:heading>
                        <flux:text class="text-red-600 dark:text-red-400 text-xs mt-2">
                            cuotas vencidas: {{ $cuotasVencidasTotal ?? 0 }}
                        </flux:text>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-xs mt-2">
                            Monto vencido: {{ $ajuste->divisa }} {{ number_format($montoVencidoTotal ?? 0, 2) }}
                        </flux:text>
                    </div>
                    <div class="p-3  dark:bg-red-900/30 rounded-lg">
                        <i class="fas fa-bell text-red-600 dark:text-red-400 text-2xl"></i>
                    </div>
                </div>
                <a href="{{ route('admin.notificaciones.index') }}"
                    class="inline-flex items-center px-3 py-1.5 bg-red-500 hohver:bg-red-500 text-white text-xs font-semibold rounded transition">
                    <i class="fas fa-eye mr-1.5"></i>Ver Listado de notificaciones
                </a>
            </div>
        @endcan

    </div>

    <style>
        .resumen-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            width: 100%;
        }
        .resumen-grid>div {
            min-width: 0;
            overflow: hidden;
        }

        @media (min-width: 1024px) {
            .resumen-grid {
                grid-template-columns: repeat(12,minmax(0, 1fr) );
            }

            .resumen-cartera {
                grid-column: span 3 / span 3;
            }

            .resumen-capital-interes {
                grid-column: span 9 / span 9;
            }
        }
    </style>

    @can('Ver listado de prestamos')
        <div class="resumen-grid mb-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3
                shadow-md hover:shadow-lg transition resumen-cartera">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:text class="text-gray-600 dark:text-gray-400 text-sm font-medium">Cartera Activa</flux:text>
                        <flux:heading size="lg" level="3" class="mt-2 text-gray-900 dark:text-white">
                            {{ $ajuste->divisa }} {{ number_format($carteraActivaTotal ?? 0, 2) }}</flux:heading>
                        <flux:text class="text-emerald-600 dark:text-emerald-400 text-xs mt-2">
                            Total Prestado: {{ $ajuste->divisa }} {{ number_format($montoPrestadoTotal ?? 0, 2) }} <br>
                            Total Recuperado:
                            {{ $ajuste->divisa }} {{ number_format($capitalRecuperadoTotal ?? 0, 2) }}
                        </flux:text>
                        <flux:text class="text-amber-600 dark:text-amber-400 text-xs mt-1">
                            Saldo Pendiente: {{ $ajuste->divisa }} {{ number_format($saldoPendienteTotal ?? 0, 2) }}
                        </flux:text>
                    </div>
                    <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                        <i class="fas fa-wallet text-emerald-600 dark:text-emerald-400 text-2xl"></i>
                    </div>
                </div>
                <div class="h-52">
                    <canvas id="chartCartera" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3 shadow-md hover:shadow-lg transition"
                style="grid-column: span 9 / span 9;">
                <div class="flex items-center justify-between mb-4">

                    <flux:heading size="lg" level="3" class="text-gray-900 dark:text-white">Capital vs Interés
                        por mes
                    </flux:heading>
                </div>
                <div style="height: 420px;">
                    <canvas id="chartCapitalInteresMes" class="w-full h-full"></canvas>
                </div>
            </div>

        </div>
    @endcan




    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Chart Clientes --}}
    <script>
        (() => {
            let chart, raf;
            const cfg = () => ({
                type: "line",
                data: {
                    labels: ["S1", "S2", "S3", "S4", "S5"],
                    datasets: [{
                        data: [10, 15, 12, 20, 25],
                        borderColor: "#3B82F6",
                        backgroundColor: "rgba(59,130,246,.12)",
                        borderWidth: 2,
                        fill: true,
                        tension: .4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            min: 0
                        },
                        x: {
                            display: false
                        }
                    }
                }
            });

            const init = () => {
                const el = document.getElementById("chartClientes");
                if (!el) return;
                chart?.destroy?.();
                chart = new Chart(el, cfg());
            };

            ["DOMContentLoaded", "livewire:load"].forEach(e => document.addEventListener(e, init));
            init();

            new MutationObserver(() => {
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    raf = null;
                    init();
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>

    {{-- Chart Roles --}}
    <script>
        (() => {
            let chart, raf;
            const cfg = () => ({
                type: "line",
                data: {
                    labels: ["S1", "S2", "S3", "S4", "S5"],
                    datasets: [{
                        data: [10, 15, 12, 20, 25],
                        borderColor: "#10B981",
                        backgroundColor: "rgba(16,185,129,.12)",
                        borderWidth: 2,
                        fill: true,
                        tension: .4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            min: 0
                        },
                        x: {
                            display: false
                        }
                    }
                }
            });

            const init = () => {
                const el = document.getElementById("chartRoles");
                if (!el) return;
                chart?.destroy?.();
                chart = new Chart(el, cfg());
            };

            ["DOMContentLoaded", "livewire:load"].forEach(e => document.addEventListener(e, init));
            init();

            new MutationObserver(() => {
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    raf = null;
                    init();
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>

    {{-- Chart Usuarios --}}
    <script>
        (() => {
            let chart, raf;
            const cfg = () => ({
                type: "line",
                data: {
                    labels: ["S1", "S2", "S3", "S4", "S5"],
                    datasets: [{
                        data: [10, 15, 12, 20, 25],
                        borderColor: "#8B5CF6",
                        backgroundColor: "rgba(139,92,246,.12)",
                        borderWidth: 2,
                        fill: true,
                        tension: .4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            min: 0
                        },
                        x: {
                            display: false
                        }
                    }
                }
            });

            const init = () => {
                const el = document.getElementById("chartUsuarios");
                if (!el) return;
                chart?.destroy?.();
                chart = new Chart(el, cfg());
            };

            ["DOMContentLoaded", "livewire:load"].forEach(e => document.addEventListener(e, init));
            init();

            new MutationObserver(() => {
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    raf = null;
                    init();
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>

    {{-- Chart Categorias --}}
    <script>
        (() => {
            let chart, raf;
            const cfg = () => ({
                type: "line",
                data: {
                    labels: ["S1", "S2", "S3", "S4", "S5"],
                    datasets: [{
                        data: [10, 15, 12, 20, 25],
                        borderColor: "#F59E0B",
                        backgroundColor: "rgba(245,158,11,.12)",
                        borderWidth: 2,
                        fill: true,
                        tension: .4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            min: 0
                        },
                        x: {
                            display: false
                        }
                    }
                }
            });

            const init = () => {
                const el = document.getElementById("chartCategorias");
                if (!el) return;
                chart?.destroy?.();
                chart = new Chart(el, cfg());
            };

            ["DOMContentLoaded", "livewire:load"].forEach(e => document.addEventListener(e, init));
            init();

            new MutationObserver(() => {
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    raf = null;
                    init();
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>

    {{-- Chart Prestamos --}}
    <script>
        (() => {
            let chart, raf;
            const cfg = () => ({
                type: "line",
                data: {
                    labels: ["S1", "S2", "S3", "S4", "S5"],
                    datasets: [{
                        data: [10, 15, 12, 20, 25],
                        borderColor: "#E11D48",
                        backgroundColor: "rgba(225,29,72,.12)",
                        borderWidth: 2,
                        fill: true,
                        tension: .4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            min: 0
                        },
                        x: {
                            display: false
                        }
                    }
                }
            });

            const init = () => {
                const el = document.getElementById("chartPrestamos");
                if (!el) return;
                chart?.destroy?.();
                chart = new Chart(el, cfg());
            };

            ["DOMContentLoaded", "livewire:load"].forEach(e => document.addEventListener(e, init));
            init();

            new MutationObserver(() => {
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    raf = null;
                    init();
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>

    {{-- Chart Prestamos Activos --}}
    <script>
        (() => {
            let chart, raf;
            const cfg = () => ({
                type: "line",
                data: {
                    labels: ["S1", "S2", "S3", "S4", "S5"],
                    datasets: [{
                        data: [10, 15, 12, 20, 25],
                        borderColor: "#06B6D4",
                        backgroundColor: "rgba(6,182,212,.12)",
                        borderWidth: 2,
                        fill: true,
                        tension: .4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            min: 0
                        },
                        x: {
                            display: false
                        }
                    }
                }
            });

            const init = () => {
                const el = document.getElementById("chartPrestamosActivos");
                if (!el) return;
                chart?.destroy?.();
                chart = new Chart(el, cfg());
            };

            ["DOMContentLoaded", "livewire:load"].forEach(e => document.addEventListener(e, init));
            init();

            new MutationObserver(() => {
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    raf = null;
                    init();
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>

    {{-- Chart Cartera --}}
    <script>
        (() => {
            let chart, raf;
            const cfg = () => ({
                type: "doughnut",
                data: {
                    labels: ["Capital recuperado", "Saldo pendiente"],
                    datasets: [{
                        data: [{{ (float) ($capitalRecuperadoTotal ?? 0) }},
                            {{ (float) ($saldoPendienteTotal ?? 0) }}
                        ],
                        backgroundColor: ["rgba(16,185,129,.9)", "rgba(245,158,11,.85)"],
                        borderColor: ["#10B981", "#F59E0B"],
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            const init = () => {
                const el = document.getElementById("chartCartera");
                if (!el) return;
                chart?.destroy?.();
                chart = new Chart(el, cfg());
            };

            ["DOMContentLoaded", "livewire:load"].forEach(e => document.addEventListener(e, init));
            init();

            new MutationObserver(() => {
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    raf = null;
                    init();
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>

    {{-- Chart Capital vs Interes por mes --}}
    <script>
        (() => {
            let chart, raf;
            const cfg = () => ({
                type: "bar",
                data: {
                    labels: @json($labelsCapitalInteres ?? []),
                    datasets: [{
                            label: "Capital",
                            data: @json($datosCapitalMes ?? []),
                            backgroundColor: "rgba(16,185,129,.75)",
                            borderColor: "#10B981",
                            borderWidth: 1,
                            borderRadius: 4,
                        },
                        {
                            label: "Interés",
                            data: @json($datosInteresMes ?? []),
                            backgroundColor: "rgba(245,158,11,.75)",
                            borderColor: "#F59E0B",
                            borderWidth: 1,
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "top"
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 0,
                                minRotation: 0
                            }
                        }
                    }
                }
            });

            const init = () => {
                const el = document.getElementById("chartCapitalInteresMes");
                if (!el) return;
                chart?.destroy?.();
                chart = new Chart(el, cfg());
            };

            ["DOMContentLoaded", "livewire:load"].forEach(e => document.addEventListener(e, init));
            init();

            new MutationObserver(() => {
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    raf = null;
                    init();
                });
            }).observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>


</x-layouts.app>

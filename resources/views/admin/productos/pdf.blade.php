<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos - THE GAME SRL</title>

    <style>
        @page {
            margin: 22px 25px 35px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #1f2937;
        }

        .titulo {
            background-color: #173b70;
            color: #ffffff;
            text-align: center;
            padding: 12px;
            font-size: 15px;
            font-weight: bold;
        }

        .subtitulo {
            margin-top: 12px;
            margin-bottom: 12px;
            font-size: 9px;
        }

        .subtitulo table {
            width: 100%;
        }

        table.inventario {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .inventario th {
            background-color: #2563eb;
            color: white;
            padding: 7px 4px;
            border: 1px solid #d1d5db;
            text-align: center;
        }

        .inventario td {
            border: 1px solid #d1d5db;
            padding: 5px 4px;
            vertical-align: middle;
            overflow-wrap: break-word;
        }

        .inventario tbody tr:nth-child(even) {
            background-color: #f1f5f9;
        }

        .inventario thead {
            display: table-header-group;
        }

        .inventario tr {
            page-break-inside: avoid;
        }

        .centro {
            text-align: center;
        }

        .pie {
            position: fixed;
            bottom: -22px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #64748b;
            border-top: 1px solid #cbd5e1;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="titulo">
        THE GAME SRL - INVENTARIO DE PRODUCTOS
    </div>

    <div class="subtitulo">
        <table>
            <tr>
                <td>
                    <strong>Fecha de emisión:</strong>
                    {{ $fecha }}
                </td>
                <td style="text-align: right;">
                    <strong>Total de productos:</strong>
                    {{ number_format($productos->count(), 0, ',', '.') }}
                </td>
            </tr>
        </table>

        @if($buscar !== '')
            <p>
                <strong>Filtro aplicado:</strong>
                {{ $buscar }}
            </p>
        @endif
    </div>

    <table class="inventario">
        <colgroup>
            <col style="width: 4%;">
            <col style="width: 12%;">
            <col style="width: 24%;">
            <col style="width: 12%;">
            <col style="width: 10%;">
            <col style="width: 13%;">
            <col style="width: 13%;">
            <col style="width: 5%;">
            <col style="width: 7%;">
        </colgroup>

        <thead>
            <tr>
                <th>Nro</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Stock</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            @forelse($productos as $producto)
                <tr>
                    <td class="centro">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $producto->codigo ?? '-' }}
                    </td>

                    <td>
                        {{ $producto->nombre }}
                    </td>

                    <td>
                        {{ $producto->categoria?->nombre ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $producto->marca ?? '-' }}
                    </td>

                    <td>
                        {{ $producto->modelo ?? '-' }}
                    </td>

                    <td>
                        {{ $producto->serie ?? '-' }}
                    </td>

                    <td class="centro">
                        {{ $producto->stock }}
                    </td>

                    <td class="centro">
                        {{ $producto->deleted_at || $producto->estado === 'Inactivo'
                            ? 'Inactivo'
                            : 'Activo' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="centro">
                        No se encontraron productos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pie">
        THE GAME SRL - Sistema de Inventario
        | Documento generado automáticamente
    </div>

</body>
</html>

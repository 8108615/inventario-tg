
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Categorías - THE GAME SRL</title>

    <style>
        @page {
            margin: 25px 25px 35px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #1f2937;
        }

        .titulo {
            background-color: #1e3a5f;
            color: white;
            text-align: center;
            padding: 12px;
            font-size: 15px;
            font-weight: bold;
        }

        .informacion {
            width: 100%;
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 9px;
        }

        .informacion td {
            padding: 4px 2px;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .tabla th {
            background-color: #2563eb;
            color: white;
            padding: 8px 5px;
            border: 1px solid #cbd5e1;
            text-align: center;
        }

        .tabla td {
            border: 1px solid #cbd5e1;
            padding: 7px 5px;
            word-wrap: break-word;
        }

        .tabla tbody tr:nth-child(even) {
            background-color: #f1f5f9;
        }

        .centrado {
            text-align: center;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        .pie {
            position: fixed;
            bottom: -22px;
            left: 0;
            right: 0;
            border-top: 1px solid #cbd5e1;
            padding-top: 6px;
            text-align: center;
            font-size: 8px;
            color: #64748b;
        }
    </style>
</head>

<body>

    <div class="titulo">
        THE GAME SRL - LISTADO DE CATEGORÍAS
    </div>

    <table class="informacion">
        <tr>
            <td>
                <strong>Fecha de emisión:</strong>
                {{ $fecha }}
            </td>

            <td style="text-align: right;">
                <strong>Total de categorías:</strong>
                {{ $categorias->count() }}
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <strong>Filtro aplicado:</strong>
                {{ $buscar !== '' ? $buscar : 'Todos' }}
            </td>
        </tr>
    </table>

    <table class="tabla">
        <thead>
            <tr>
                <th style="width: 7%;">Nro</th>
                <th style="width: 25%;">Nombre</th>
                <th style="width: 53%;">Descripción</th>
                <th style="width: 15%;">Estado</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($categorias as $categoria)
                <tr>
                    <td class="centrado">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $categoria->nombre }}
                    </td>

                    <td>
                        {{ $categoria->descripcion ?? 'Sin descripción' }}
                    </td>

                    <td class="centrado">
                        {{ $categoria->deleted_at || $categoria->estado === 'Inactivo'
                            ? 'Inactivo'
                            : 'Activo' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="centrado">
                        No se encontraron categorías.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pie">
        THE GAME SRL - Sistema de Inventario |
        Documento generado automáticamente
    </div>

</body>
</html>

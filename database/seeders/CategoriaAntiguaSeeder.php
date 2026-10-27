<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaAntiguaSeeder extends Seeder
{
    public function run(): void
    {
        $categoriasAntiguas = [
            ['nombre' => 'PCR01', 'descripcion' => 'SALA CONTROL DE PRODUCCION01 AL LADO DE PCR3 MP', 'estado' => 'Activo'],
            ['nombre' => 'UM 01', 'descripcion' => 'CAMION IVECO', 'estado' => 'Activo'],
            ['nombre' => 'UM 02', 'descripcion' => 'MINI BANS JAC', 'estado' => 'Activo'],
            ['nombre' => 'ALMACEN', 'descripcion' => 'DEPOSITO PUERTA DERECHA DE EL FONDO DE LA OFICONA EUCALIPTO', 'estado' => 'Activo'],
            ['nombre' => 'PCR02', 'descripcion' => 'SALA CONTROL DE PRODUCCION02 AL LADO DER DE PCR3 MP', 'estado' => 'Activo'],
            ['nombre' => 'DATA01R2', 'descripcion' => 'DATA CENTE PRINCIPAL TG', 'estado' => 'Activo'],
            ['nombre' => 'DATA01R1', 'descripcion' => 'DATA CENTE PRINCIPAL TG', 'estado' => 'Activo'],
            ['nombre' => 'SALA DE REUNIONES', 'descripcion' => 'CONSTRUCCION OFICINAS ADELANTE PISO 1', 'estado' => 'Activo'],
            ['nombre' => 'DATA01R3', 'descripcion' => 'DATA CENTE PRINCIPAL TG', 'estado' => 'Activo'],
            ['nombre' => 'MCR', 'descripcion' => 'CONSTRUCCION NUENVA AL LADO DEL DATA 01 PRINCIPAL', 'estado' => 'Activo'],
            ['nombre' => 'EA NUEVOS', 'descripcion' => 'EQUIPOS NUEVOS EN SALA GERENCIA', 'estado' => 'Activo'],
            ['nombre' => 'GERENCIA 1', 'descripcion' => 'GERENCIA 1 JOSE LUIS QUIROGA', 'estado' => 'Activo'],
            ['nombre' => 'DATA01R4', 'descripcion' => 'DATA CENTE PRINCIPAL TG', 'estado' => 'Activo'],
            ['nombre' => 'DATA01R5', 'descripcion' => 'DATA CENTE PRINCIPAL TG', 'estado' => 'Activo'],
            ['nombre' => 'DATA01', 'descripcion' => 'DATA CENTE PRINCIPAL TG', 'estado' => 'Activo'],
            ['nombre' => 'DATA01R0', 'descripcion' => 'DATA CENTE PRINCIPAL TG', 'estado' => 'Activo'],
            ['nombre' => 'CABINA02', 'descripcion' => 'CABINA ANTIGUA DENTRO DE PCR2, IGRESANDO POR PCR3 MP', 'estado' => 'Activo'],
            ['nombre' => 'M-A/C-DATA01', 'descripcion' => 'MUEBLES Y A/C DATA 01 PRINCIPAL', 'estado' => 'Activo'],
            ['nombre' => 'M-A/C-MCR', 'descripcion' => 'MUEBLES Y A/C DE MCR', 'estado' => 'Activo'],
            ['nombre' => 'M-A/C-PCR02', 'descripcion' => 'MUEBLE Y A/C DE PCR2', 'estado' => 'Activo'],
            ['nombre' => 'M-A/C-PCR01', 'descripcion' => 'MUEBLE Y A/C DE PCR1', 'estado' => 'Activo'],
            ['nombre' => 'PRENSA', 'descripcion' => 'EQUIPOS DE PRENSA TG (AREA REDACCION)', 'estado' => 'Activo'],
            ['nombre' => 'ESTUDIO MEDIAPRO', 'descripcion' => 'SET DE GRABACION', 'estado' => 'Activo'],
            ['nombre' => 'PCR MEDIAPRO', 'descripcion' => 'SALA CONTROL DE PRODUCCION MEDIA PRODUCCION', 'estado' => 'Activo'],
            ['nombre' => 'REDACCION MEDIAPRO', 'descripcion' => 'EQUIPOS AREA REDACCION DE MEDIA PRODUCCION', 'estado' => 'Activo'],
            ['nombre' => 'PRENSA MEDIAPRO', 'descripcion' => 'EQUIPOS DE PRENSA MEDIAPRO', 'estado' => 'Activo'],
            ['nombre' => 'RECEPCION', 'descripcion' => 'CONSTRUCCION DELANTERA, PLANTA BAJA OF ADM', 'estado' => 'Activo'],
            ['nombre' => 'ALMACEN BAJA', 'descripcion' => 'EQUIPOS QUE SON ANTIGUOS VIEJOS Y EN DESUSO', 'estado' => 'Activo'],
            ['nombre' => 'M-AC-PCR01', 'descripcion' => 'MUEBLERIA Y A/C PCR01', 'estado' => 'Activo'],
            ['nombre' => 'GERENCIA 2', 'descripcion' => 'OFICINA 1ER PISO -JOSE MARIA QUIROGA', 'estado' => 'Activo'],
            ['nombre' => 'ESTUDIO ESTATICA', 'descripcion' => 'OFICINA PLANTA BAJA A LADO DE LA COCINA', 'estado' => 'Activo'],
            ['nombre' => 'ADMINISTRACION', 'descripcion' => '1ER PISO ( AREA COMERCIAL Y RRHH)', 'estado' => 'Activo'],
            ['nombre' => 'CONTABILIDAD', 'descripcion' => 'OFICINA PLANTA ALTA FONDO', 'estado' => 'Activo'],
            ['nombre' => 'SEGURIDAD', 'descripcion' => 'OFICINAAL INGRESO DEL EDIFICIO PARA LOS GUARDIAS DE SEGURIDAD', 'estado' => 'Activo'],
            ['nombre' => 'ARCHIVO ADMINISTRATIVO', 'descripcion' => 'ARCHIVO DE CONTABILIDAD,COMERCIAL, GERENCIA Y RRHH 1ER PISO', 'estado' => 'Activo'],
            ['nombre' => 'COCINA ADM', 'descripcion' => 'CONSTRUCCION DELANTERA, PLANTA BAJA, ATRAS DE RECEPCION', 'estado' => 'Activo'],
            ['nombre' => 'TG COCINA FONDO', 'descripcion' => 'COCINA DEL FONDO', 'estado' => 'Activo'],
            ['nombre' => 'PATIO Y ANTENAS', 'descripcion' => 'PATIO Y ANTENAS', 'estado' => 'Activo'],
            ['nombre' => 'PERSONAL TG', 'descripcion' => 'EQUIPOS ENTREGADOS AL PERSONAL PARA LAS OPERACIONES Y PRODUCCIONES', 'estado' => 'Activo'],
            ['nombre' => 'ESTUDIO TG', 'descripcion' => 'EQUIPOS EN ESTUDIO THE GAME', 'estado' => 'Activo'],
            ['nombre' => 'DATA SEÑALES', 'descripcion' => 'DATA CENTER DE SEÑALES Y DISTRIBUCION A CABECERA', 'estado' => 'Activo'],
            ['nombre' => 'CABINA 01', 'descripcion' => 'CABINA 01 DE LA ENTRADA', 'estado' => 'Activo'],
            ['nombre' => 'PCR-STREAMING', 'descripcion' => 'PCR STREAMING', 'estado' => 'Activo'],
            ['nombre' => 'NUEVOS-2026', 'descripcion' => 'CATEGORIA NUEVA', 'estado' => 'Activo'],
        ];

        foreach ($categoriasAntiguas as $cat) {
            Categoria::firstOrCreate(
                ['nombre' => $cat['nombre']],
                ['descripcion' => $cat['descripcion'], 'estado' => $cat['estado']]
            );
        }
    }
}

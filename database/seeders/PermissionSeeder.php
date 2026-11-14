<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            ['Administrar usuarios', 'usuarios.administrar'],
            ['Administrar roles', 'roles.administrar'],
            ['Administrar permisos', 'permisos.administrar'],

            ['Ver productos', 'productos.ver'],
            ['Gestionar productos', 'productos.gestionar'],
            ['Gestionar inventario', 'inventario.gestionar'],

            ['Ver pedidos', 'pedidos.ver'],
            ['Crear pedidos', 'pedidos.crear'],
            ['Gestionar pedidos', 'pedidos.gestionar'],
            ['Cancelar pedidos', 'pedidos.cancelar'],

            ['Ver ventas', 'ventas.ver'],
            ['Gestionar comprobantes', 'comprobantes.gestionar'],
            ['Gestionar devoluciones', 'devoluciones.gestionar'],

            ['Gestionar entregas', 'entregas.gestionar'],
            ['Asignar repartidores', 'repartidores.asignar'],
            ['Ver entregas asignadas', 'entregas.asignadas'],
            ['Actualizar estado de entrega', 'entregas.actualizar'],

            ['Gestionar proveedores', 'proveedores.gestionar'],
            ['Ver portal proveedor', 'proveedores.portal'],

            ['Gestionar zonas de delivery', 'delivery.zonas'],
            ['Gestionar horarios de delivery', 'delivery.horarios'],

            ['Ver reportes', 'reportes.ver'],
            ['Gestionar reclamos', 'reclamos.gestionar'],
            ['Registrar reclamos', 'reclamos.registrar'],

            ['Ver perfil propio', 'perfil.ver'],
            ['Editar perfil propio', 'perfil.editar'],
        ];

        foreach ($permisos as [$nombre, $slug]) {
            Permission::firstOrCreate(
                ['slug' => $slug],
                [
                    'nombre' => $nombre,
                    'descripcion' => $nombre,
                    'estado' => true,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $asignaciones = [
            'Administrador de ventas' => [
                'productos.ver',
                'pedidos.ver',
                'pedidos.gestionar',
                'pedidos.cancelar',
                'ventas.ver',
                'reclamos.gestionar',
            ],

            'Gestor de inventario' => [
                'productos.ver',
                'productos.gestionar',
                'inventario.gestionar',
                'proveedores.gestionar',
            ],

            'Gestor contable' => [
                'pedidos.ver',
                'ventas.ver',
                'comprobantes.gestionar',
                'devoluciones.gestionar',
                'reportes.ver',
            ],

            'Coordinador de delivery' => [
                'pedidos.ver',
                'entregas.gestionar',
                'repartidores.asignar',
                'delivery.zonas',
                'delivery.horarios',
            ],

            'Repartidor' => [
                'entregas.asignadas',
                'entregas.actualizar',
            ],

            'Proveedor' => [
                'proveedores.portal',
            ],

            'Cliente' => [
                'productos.ver',
                'pedidos.crear',
                'pedidos.cancelar',
                'reclamos.registrar',
            ],
        ];

        DB::transaction(function () use ($asignaciones) {
            $permisos = Permission::where('estado', true)
                ->pluck('id', 'slug');

            $roles = Role::where('estado', true)
                ->get()
                ->keyBy('nombre');

            foreach ($asignaciones as $nombreRol => $slugs) {
                $rol = $roles->get($nombreRol);

                if (!$rol) {
                    throw new RuntimeException(
                        "No existe el rol activo: {$nombreRol}"
                    );
                }

                $ids = [];

                foreach ($slugs as $slug) {
                    if (!$permisos->has($slug)) {
                        throw new RuntimeException(
                            "No existe el permiso activo: {$slug}"
                        );
                    }

                    $ids[] = $permisos->get($slug);
                }

                $rol->permissions()->syncWithoutDetaching($ids);
            }

            $superadministrador = $roles->get('Superadministrador');

            if (!$superadministrador) {
                throw new RuntimeException(
                    'No existe el rol Superadministrador'
                );
            }

            $superadministrador->permissions()
                ->syncWithoutDetaching($permisos->values()->all());
        });
    }
}

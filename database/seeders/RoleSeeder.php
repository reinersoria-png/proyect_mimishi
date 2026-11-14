<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Superadministrador', 'descripcion' => 'Administración general del sistema'],
            ['nombre' => 'Administrador de ventas', 'descripcion' => 'Gestión de pedidos y ventas'],
            ['nombre' => 'Gestor de inventario', 'descripcion' => 'Gestión de productos y existencias'],
            ['nombre' => 'Gestor contable', 'descripcion' => 'Gestión contable, comprobantes y devoluciones'],
            ['nombre' => 'Coordinador de delivery', 'descripcion' => 'Coordinación de entregas y repartidores'],
            ['nombre' => 'Repartidor', 'descripcion' => 'Gestión de entregas asignadas'],
            ['nombre' => 'Proveedor', 'descripcion' => 'Acceso autorizado para proveedores'],
            ['nombre' => 'Cliente', 'descripcion' => 'Compras y seguimiento de pedidos'],
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate(
                ['nombre' => $rol['nombre']],
                [
                    'descripcion' => $rol['descripcion'],
                    'estado' => true,
                ]
            );
        }
    }
}

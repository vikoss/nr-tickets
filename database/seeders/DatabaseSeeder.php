<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $tecnicoRole = Role::firstOrCreate(['name' => 'tecnico']);

        // Create default sucursales
        $sucursalCdmx = Sucursal::firstOrCreate(
            ['codigo' => 'CDMX'],
            ['nombre' => 'Ciudad de México']
        );

        $sucursalGdl = Sucursal::firstOrCreate(
            ['codigo' => 'GDL'],
            ['nombre' => 'Guadalajara']
        );

        $sucursalMty = Sucursal::firstOrCreate(
            ['codigo' => 'MTY'],
            ['nombre' => 'Monterrey']
        );

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'numero_empleado' => 'ADM001',
                'sucursal_id' => $sucursalCdmx->id,
            ]
        );
        $admin->assignRole($adminRole);

        // Create tecnico user
        $tecnico = User::firstOrCreate(
            ['email' => 'tecnico@example.com'],
            [
                'name' => 'Técnico Demo',
                'password' => Hash::make('password'),
                'numero_empleado' => 'TEC001',
                'sucursal_id' => $sucursalCdmx->id,
            ]
        );
        $tecnico->assignRole($tecnicoRole);
    }
}

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
            ['email' => 'alex-admin@example.com'],
            [
                'name' => 'Alex Admin',
                'password' => Hash::make('password4dm1n'),
                'numero_empleado' => '00001',
                'sucursal_id' => $sucursalCdmx->id,
            ]
        );
        $admin->assignRole($adminRole);

        // Create tecnico user
        $tecnico = User::firstOrCreate(
            ['email' => 'alex-tecnico@example.com'],
            [
                'name' => 'Alex Tecnico',
                'password' => Hash::make('passwordT3cn1c0'),
                'numero_empleado' => '00002',
                'sucursal_id' => $sucursalCdmx->id,
            ]
        );
        $tecnico->assignRole($tecnicoRole);
    }
}

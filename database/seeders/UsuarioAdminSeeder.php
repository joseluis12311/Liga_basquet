<?php

namespace Database\Seeders;

use App\Enums\RolUsuario;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsuarioAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@liga.test']);
        $admin->name = 'Administrador';
        $admin->password = 'password123';
        $admin->rol = RolUsuario::Administrador;
        $admin->save();
    }
}
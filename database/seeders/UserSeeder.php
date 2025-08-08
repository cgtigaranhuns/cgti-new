<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário administrador padrão
        User::create([
            'name' => 'Administrador CGTI',
            'email' => 'admin@cgti.garanhuns.ifpe.edu.br',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'active' => true,
            'department' => 'CGTI',
            'phone' => '(87) 3761-1000',
        ]);

        // Usuário de teste
        User::create([
            'name' => 'Usuário Teste',
            'email' => 'teste@cgti.garanhuns.ifpe.edu.br',
            'password' => Hash::make('teste123'),
            'role' => 'user',
            'active' => true,
            'department' => 'CGTI',
        ]);
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Informe;
use App\Models\User;
use Illuminate\Support\Str;

class InformeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        
        $informes = [
            [
                'title' => 'Bem-vindos ao novo site da CGTI',
                'content' => 'Estamos felizes em apresentar a nova versão do site da Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns. O site foi completamente reformulado com foco na usabilidade, segurança e responsividade.',
                'excerpt' => 'Conheça a nova versão do site da CGTI com design moderno e funcionalidades aprimoradas.',
                'published' => true,
                'published_at' => now()->subDays(1),
                'user_id' => $admin->id,
                'views' => 45,
            ],
            [
                'title' => 'Manutenção programada dos servidores',
                'content' => 'Informamos que será realizada manutenção preventiva nos servidores da CGTI no próximo sábado, das 8h às 12h. Durante este período, alguns serviços poderão ficar indisponíveis temporariamente.',
                'excerpt' => 'Manutenção preventiva dos servidores será realizada no sábado das 8h às 12h.',
                'published' => true,
                'published_at' => now()->subDays(3),
                'user_id' => $admin->id,
                'views' => 78,
            ],
            [
                'title' => 'Novos procedimentos de segurança',
                'content' => 'A CGTI implementou novos procedimentos de segurança para proteger os dados e sistemas do campus. Todos os usuários devem atualizar suas senhas seguindo as novas diretrizes de segurança.',
                'excerpt' => 'Implementação de novos procedimentos de segurança e atualização de senhas.',
                'published' => true,
                'published_at' => now()->subWeek(),
                'user_id' => $admin->id,
                'views' => 123,
            ],
        ];

        foreach ($informes as $informeData) {
            $informeData['slug'] = Str::slug($informeData['title']);
            Informe::create($informeData);
        }
    }
}


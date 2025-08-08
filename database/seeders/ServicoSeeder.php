<?php

namespace Database\Seeders;

use App\Models\Servico;
use Illuminate\Database\Seeder;

class ServicoSeeder extends Seeder
{
    public function run(): void
    {
        $servicos = [
            [
                'name' => 'Solicitação de Veículos e Diárias',
                'description' => 'Sistema para solicitação de veículos e diárias de viagem',
                'url' => 'https://cgti.garanhuns.ifpe.edu.br/sistemas/sistd/',
                'icon' => 'car',
                'category' => 'administrativo',
                'active' => true,
                'internal' => false,
                'order' => 1,
            ],
            [
                'name' => 'SCOLAR',
                'description' => 'Sistema de Controle Acadêmico',
                'url' => 'http://scolar.garanhuns.ifpe.edu.br',
                'icon' => 'graduation-cap',
                'category' => 'academico',
                'active' => true,
                'internal' => false,
                'order' => 2,
            ],
            [
                'name' => 'SISDIEX',
                'description' => 'Sistema de Extensão',
                'url' => 'http://extensao.garanhuns.ifpe.edu.br',
                'icon' => 'users',
                'category' => 'academico',
                'active' => true,
                'internal' => false,
                'order' => 3,
            ],
            [
                'name' => 'Gestão de Pessoas',
                'description' => 'Sistema de Gestão de Recursos Humanos',
                'url' => 'https://cgti.garanhuns.ifpe.edu.br/sistemas/sisgp/sistemaCGPE/cadastroServidor',
                'icon' => 'people',
                'category' => 'rh',
                'active' => true,
                'internal' => false,
                'order' => 4,
            ],
            [
                'name' => 'Avaliação de Estágio Probatório',
                'description' => 'Sistema para avaliação de servidores em estágio probatório',
                'url' => 'https://cgti.garanhuns.ifpe.edu.br/sistemas/sisgp/sistemaCGPE/estagioProbatorio',
                'icon' => 'clipboard-check',
                'category' => 'rh',
                'active' => true,
                'internal' => false,
                'order' => 5,
            ],
            [
                'name' => 'Avaliação de Estagiários',
                'description' => 'Sistema para avaliação de estagiários',
                'url' => 'https://cgti.garanhuns.ifpe.edu.br/sistemas/sisgp/sistemaCGPE/avaliacaoEstagiario',
                'icon' => 'user-check',
                'category' => 'rh',
                'active' => true,
                'internal' => false,
                'order' => 6,
            ],
            [
                'name' => 'Formulário de Requerimentos',
                'description' => 'Sistema para submissão de requerimentos diversos',
                'url' => 'https://cgti.garanhuns.ifpe.edu.br/sistemas/sisgp/sistemaCGPE/requerimento',
                'icon' => 'file-text',
                'category' => 'geral',
                'active' => true,
                'internal' => false,
                'order' => 7,
            ],
        ];

        foreach ($servicos as $servico) {
            Servico::create($servico);
        }
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informe;
use App\Models\Documento;
use App\Models\Processo;
use App\Models\Equipe;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        // Estatísticas gerais
        $stats = [
            'informes' => [
                'total' => Informe::count(),
                'publicados' => Informe::published()->count(),
                'rascunhos' => Informe::where('published', false)->count(),
                'este_mes' => Informe::whereMonth('created_at', now()->month)->count(),
            ],
            'documentos' => [
                'total' => Documento::count(),
                'ativos' => Documento::ativo()->count(),
                'downloads' => Documento::sum('downloads'),
                'este_mes' => Documento::whereMonth('created_at', now()->month)->count(),
            ],
            'processos' => [
                'total' => Processo::count(),
                'ativos' => Processo::ativo()->count(),
                'downloads' => Processo::sum('downloads'),
                'este_mes' => Processo::whereMonth('created_at', now()->month)->count(),
            ],
            'equipe' => [
                'total' => Equipe::count(),
                'ativos' => Equipe::ativo()->count(),
                'este_mes' => Equipe::whereMonth('created_at', now()->month)->count(),
            ],
            'usuarios' => [
                'total' => User::count(),
                'admins' => User::where('role', 'admin')->count(),
                'este_mes' => User::whereMonth('created_at', now()->month)->count(),
            ]
        ];

        // Atividades recentes
        $informes_recentes = Informe::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $documentos_recentes = Documento::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Mais baixados
        $documentos_populares = Documento::ativo()
            ->orderBy('downloads', 'desc')
            ->limit(5)
            ->get();

        $processos_populares = Processo::ativo()
            ->orderBy('downloads', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'informes_recentes',
            'documentos_recentes',
            'documentos_populares',
            'processos_populares'
        ));
    }
}


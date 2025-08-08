<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use App\Models\Servico;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Buscar serviços ativos ordenados
        $servicos = Servico::active()->public()->ordered()->get();
        $servicosInternos = Servico::active()->internal()->ordered()->get();
        
        // Buscar informes recentes publicados
        $informes = Informe::published()->recent()->take(5)->get();
        
        return view('home', compact('servicos', 'servicosInternos', 'informes'));
    }

    public function apresentacao()
    {
        return view('apresentacao');
    }

    public function contato()
    {
        return view('contato');
    }

    public function enviarContato(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string|max:2000',
        ]);

        // Aqui você pode implementar o envio de email
        // Mail::to('cgti@garanhuns.ifpe.edu.br')->send(new ContatoMail($request->all()));

        return back()->with('success', 'Mensagem enviada com sucesso!');
    }
}


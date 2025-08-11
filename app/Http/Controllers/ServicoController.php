<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Buscar serviços ativos ordenados
        $servicos = Servico::active()->public()->ordered()->get();
        $servicosInternos = Servico::active()->where('internal', 1)->ordered()->get();
        $servicosInstitucional = Servico::active()->where('internal', 2)->ordered()->get();
        $servicosGovernamental = Servico::active()->where('internal', 3)->ordered()->get();
        return view('servico', compact('servicos', 'servicosInternos', 'servicosInstitucional', 'servicosGovernamental'));
    }
/*
    /**
     * Show the form for creating a new resource.
     *//*
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *//*
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *//*
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *//*
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *//*
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *//*
    public function destroy(string $id)
    {
        //
    }*/
}
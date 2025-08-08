<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipeController extends Controller
{
    public function index()
    {
        $membros = Equipe::ativo()->orderBy('ordem')->orderBy('nome')->get();
        return view('equipe.index', compact('membros'));
    }

    public function show(Equipe $equipe)
    {
        if (!$equipe->ativo) {
            abort(404);
        }
        
        return view('equipe.show', compact('equipe'));
    }

    // Métodos para admin (protegidos por middleware)
    public function create()
    {
        return view('admin.equipe.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'formacao' => 'nullable|string',
            'conhecimentos' => 'nullable|string',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['foto'] = $file->storeAs('equipe', $fileName, 'public');
        }

        Equipe::create($data);

        return redirect()->route('admin.equipe.index')->with('success', 'Membro da equipe criado com sucesso!');
    }

    public function edit(Equipe $equipe)
    {
        return view('admin.equipe.edit', compact('equipe'));
    }

    public function update(Request $request, Equipe $equipe)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'formacao' => 'nullable|string',
            'conhecimentos' => 'nullable|string',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Deletar foto anterior se existir
            if ($equipe->foto) {
                Storage::disk('public')->delete($equipe->foto);
            }

            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['foto'] = $file->storeAs('equipe', $fileName, 'public');
        }

        $equipe->update($data);

        return redirect()->route('admin.equipe.index')->with('success', 'Membro da equipe atualizado com sucesso!');
    }

    public function destroy(Equipe $equipe)
    {
        // Deletar foto se existir
        if ($equipe->foto) {
            Storage::disk('public')->delete($equipe->foto);
        }

        $equipe->delete();
        
        return redirect()->route('admin.equipe.index')->with('success', 'Membro da equipe excluído com sucesso!');
    }
}
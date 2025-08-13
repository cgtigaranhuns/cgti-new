<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessoController extends Controller
{
    public function index()
{
    $processos = Processo::query()
        ->when(request('search'), function ($query) {
            $query->where('titulo', 'like', '%'.request('search').'%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('processos.index', compact('processos'));
}

public function porCoordenacao($categoria)
{
    $processos = Processo::where('categoria', $categoria)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('processos.processos-por-coordenacao', compact('processos', 'categoria'));
}

    public function show(Processo $processo)
    {
        if (!$processo->ativo) {
            abort(404);
        }
        
        return view('processos.show', compact('processo'));
    }

    public function download(Processo $processo)
    {
        if (!$processo->ativo || !$processo->arquivo_path) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $processo->arquivo_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        // Incrementar contador de downloads
        $processo->incrementarDownload();

        return response()->download($filePath, $processo->arquivo_nome);
    }

    // Métodos para admin (protegidos por middleware)
    public function create()
    {
        $categorias = Processo::getCategorias();
        return view('admin.processos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'categoria' => 'required|string|in:' . implode(',', array_keys(Processo::getCategorias())),
            'arquivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB
            'ativo' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('arquivo')) {
            $file = $request->file('arquivo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('processos', $fileName, 'public');
            
            $data['arquivo_path'] = $filePath;
            $data['arquivo_nome'] = $file->getClientOriginalName();
            $data['arquivo_tamanho'] = $file->getSize();
            $data['arquivo_tipo'] = $file->getClientMimeType();
        }

        Processo::create($data);

        return redirect()->route('admin.processos.index')->with('success', 'Processo criado com sucesso!');
    }

    public function edit(Processo $processo)
    {
        $categorias = Processo::getCategorias();
        return view('admin.processos.edit', compact('processo', 'categorias'));
    }

    public function update(Request $request, Processo $processo)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'categoria' => 'required|string|in:' . implode(',', array_keys(Processo::getCategorias())),
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB
            'ativo' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('arquivo')) {
            // Deletar arquivo anterior se existir
            if ($processo->arquivo_path) {
                Storage::disk('public')->delete($processo->arquivo_path);
            }

            $file = $request->file('arquivo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('processos', $fileName, 'public');
            
            $data['arquivo_path'] = $filePath;
            $data['arquivo_nome'] = $file->getClientOriginalName();
            $data['arquivo_tamanho'] = $file->getSize();
            $data['arquivo_tipo'] = $file->getClientMimeType();
        }

        $processo->update($data);

        return redirect()->route('admin.processos.index')->with('success', 'Processo atualizado com sucesso!');
    }

    public function destroy(Processo $processo)
    {
        // Deletar arquivo se existir
        if ($processo->arquivo_path) {
            Storage::disk('public')->delete($processo->arquivo_path);
        }

        $processo->delete();
        
        return redirect()->route('admin.processos.index')->with('success', 'Processo excluído com sucesso!');
    }
}
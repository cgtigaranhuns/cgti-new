<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        $categoria = $request->get('categoria');
        $search = $request->get('search');
        
        $documentos = Documento::ativo()
            ->when($categoria, function ($query, $categoria) {
                return $query->categoria($categoria);
            })
            ->when($search, function ($query, $search) {
                return $query->where('titulo', 'like', "%{$search}%")
                           ->orWhere('descricao', 'like', "%{$search}%");
            })
            ->orderBy('categoria')
            ->orderBy('titulo')
            ->paginate(20);

        $categorias = Documento::getCategorias();
        
        return view('documentos.index', compact('documentos', 'categorias', 'categoria', 'search'));
    }

    public function show(Documento $documento)
    {
        if (!$documento->ativo) {
            abort(404);
        }
        
        return view('documentos.show', compact('documento'));
    }

    public function download(Documento $documento)
    {
        if (!$documento->ativo || !$documento->arquivo_path) {
            abort(404);
        }

        $filePath = storage_path('app/public/' . $documento->arquivo_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        // Incrementar contador de downloads
        $documento->incrementarDownload();

        return response()->download($filePath, $documento->arquivo_nome);
    }

    // Métodos para admin (protegidos por middleware)
    public function create()
    {
        $categorias = Documento::getCategorias();
        return view('admin.documentos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'categoria' => 'required|string|in:' . implode(',', array_keys(Documento::getCategorias())),
            'arquivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB
            'ativo' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('arquivo')) {
            $file = $request->file('arquivo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documentos', $fileName, 'public');
            
            $data['arquivo_path'] = $filePath;
            $data['arquivo_nome'] = $file->getClientOriginalName();
            $data['arquivo_tamanho'] = $file->getSize();
            $data['arquivo_tipo'] = $file->getClientMimeType();
        }

        Documento::create($data);

        return redirect()->route('admin.documentos.index')->with('success', 'Documento criado com sucesso!');
    }

    public function edit(Documento $documento)
    {
        $categorias = Documento::getCategorias();
        return view('admin.documentos.edit', compact('documento', 'categorias'));
    }

    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'categoria' => 'required|string|in:' . implode(',', array_keys(Documento::getCategorias())),
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB
            'ativo' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('arquivo')) {
            // Deletar arquivo anterior se existir
            if ($documento->arquivo_path) {
                Storage::disk('public')->delete($documento->arquivo_path);
            }

            $file = $request->file('arquivo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documentos', $fileName, 'public');
            
            $data['arquivo_path'] = $filePath;
            $data['arquivo_nome'] = $file->getClientOriginalName();
            $data['arquivo_tamanho'] = $file->getSize();
            $data['arquivo_tipo'] = $file->getClientMimeType();
        }

        $documento->update($data);

        return redirect()->route('admin.documentos.index')->with('success', 'Documento atualizado com sucesso!');
    }

    public function destroy(Documento $documento)
    {
        // Deletar arquivo se existir
        if ($documento->arquivo_path) {
            Storage::disk('public')->delete($documento->arquivo_path);
        }

        $documento->delete();
        
        return redirect()->route('admin.documentos.index')->with('success', 'Documento excluído com sucesso!');
    }
}


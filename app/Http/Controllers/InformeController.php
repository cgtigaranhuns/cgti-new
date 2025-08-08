<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    public function index()
    {
        $informes = Informe::published()->recent()->paginate(10);
        return view('informes.index', compact('informes'));
    }

    public function show($slug)
    {
        $informe = Informe::where('slug', $slug)->published()->firstOrFail();
        
        // Incrementar visualizações
        $informe->increment('views');
        
        return view('informes.show', compact('informe'));
    }

    // Métodos para admin (protegidos por middleware)
    public function create()
    {
        return view('admin.informes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'published' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('informes', 'public');
        }

        if ($request->published) {
            $data['published_at'] = now();
        }

        Informe::create($data);

        return redirect()->route('admin.informes.index')->with('success', 'Informe criado com sucesso!');
    }

    public function edit(Informe $informe)
    {
        return view('admin.informes.edit', compact('informe'));
    }

    public function update(Request $request, Informe $informe)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'published' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('informes', 'public');
        }

        if ($request->published && !$informe->published) {
            $data['published_at'] = now();
        }

        $informe->update($data);

        return redirect()->route('admin.informes.index')->with('success', 'Informe atualizado com sucesso!');
    }

    public function destroy(Informe $informe)
    {
        $informe->delete();
        return redirect()->route('admin.informes.index')->with('success', 'Informe excluído com sucesso!');
    }
}


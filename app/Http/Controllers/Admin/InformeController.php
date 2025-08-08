<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InformeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Informe::with('user');

        // Filtros
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('published', true);
            } elseif ($request->status === 'draft') {
                $query->where('published', false);
            }
        }

        // Ordenação
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'views':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $informes = $query->paginate(10);

        return view('admin.informes.index', compact('informes'));
    }

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
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = auth()->id();

        // Upload da imagem
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('informes', 'public');
        }

        // Se publicado, definir data de publicação
        if ($request->published && !$request->published_at) {
            $data['published_at'] = now();
        }

        Informe::create($data);

        return redirect()->route('admin.informes.index')
                        ->with('success', 'Informe criado com sucesso!');
    }

    public function show(Informe $informe)
    {
        return view('admin.informes.show', compact('informe'));
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
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        // Upload da nova imagem
        if ($request->hasFile('featured_image')) {
            // Deletar imagem anterior
            if ($informe->featured_image) {
                Storage::disk('public')->delete($informe->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('informes', 'public');
        }

        // Se publicado pela primeira vez, definir data de publicação
        if ($request->published && !$informe->published && !$request->published_at) {
            $data['published_at'] = now();
        }

        $informe->update($data);

        return redirect()->route('admin.informes.index')
                        ->with('success', 'Informe atualizado com sucesso!');
    }

    public function destroy(Informe $informe)
    {
        // Deletar imagem se existir
        if ($informe->featured_image) {
            Storage::disk('public')->delete($informe->featured_image);
        }

        $informe->delete();

        return redirect()->route('admin.informes.index')
                        ->with('success', 'Informe excluído com sucesso!');
    }
}


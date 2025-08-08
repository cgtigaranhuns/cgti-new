@extends('layouts.admin')

@section('title', 'Gerenciar Informes')
@section('page-title', 'Informes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0 fw-bold">Gerenciar Informes</h2>
        <p class="text-muted mb-0">Crie e gerencie os informes do site</p>
    </div>
    <a href="{{ route('admin.informes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Novo Informe
    </a>
</div>

<!-- Filtros -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.informes.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Buscar informes..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Todos os status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicados</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Rascunhos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mais recentes</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Mais antigos</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Título A-Z</option>
                        <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Mais visualizados</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            
            @if(request()->hasAny(['search', 'status', 'sort']))
                <div class="mt-2">
                    <a href="{{ route('admin.informes.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-lg me-1"></i>Limpar filtros
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Lista de Informes -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @forelse($informes as $informe)
            <div class="p-4 border-bottom">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-start">
                            @if($informe->featured_image)
                                <img src="{{ asset('storage/' . $informe->featured_image) }}" 
                                     alt="{{ $informe->title }}"
                                     class="me-3 rounded"
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            @else
                                <div class="me-3 bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 60px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="flex-grow-1">
                                <h5 class="mb-1 fw-bold">
                                    <a href="{{ route('admin.informes.edit', $informe) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $informe->title }}
                                    </a>
                                </h5>
                                
                                @if($informe->excerpt)
                                    <p class="text-muted mb-2">{{ Str::limit($informe->excerpt, 100) }}</p>
                                @endif
                                
                                <div class="small text-muted">
                                    <span class="me-3">
                                        <i class="bi bi-person me-1"></i>{{ $informe->user->name ?? 'Sistema' }}
                                    </span>
                                    <span class="me-3">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $informe->created_at->format('d/m/Y H:i') }}
                                    </span>
                                    @if($informe->published_at)
                                        <span class="me-3">
                                            <i class="bi bi-broadcast me-1"></i>{{ $informe->published_at->format('d/m/Y H:i') }}
                                        </span>
                                    @endif
                                    <span>
                                        <i class="bi bi-eye me-1"></i>{{ $informe->views }} visualizações
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 text-md-end">
                        <div class="mb-2">
                            @if($informe->published)
                                <span class="badge bg-success">Publicado</span>
                            @else
                                <span class="badge bg-warning">Rascunho</span>
                            @endif
                        </div>
                        
                        <div class="btn-group" role="group">
                            @if($informe->published)
                                <a href="{{ route('informes.show', $informe->slug) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-primary btn-sm"
                                   title="Ver no site">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @endif
                            
                            <a href="{{ route('admin.informes.edit', $informe) }}" 
                               class="btn btn-outline-secondary btn-sm"
                               title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <button type="button" 
                                    class="btn btn-outline-danger btn-sm"
                                    title="Excluir"
                                    onclick="confirmarExclusao('{{ $informe->id }}', '{{ $informe->title }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-5 text-center">
                <div class="mb-4">
                    <i class="bi bi-newspaper text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-muted">Nenhum informe encontrado</h4>
                <p class="text-muted mb-4">
                    @if(request()->hasAny(['search', 'status']))
                        Não encontramos informes com os filtros aplicados.
                    @else
                        Comece criando seu primeiro informe.
                    @endif
                </p>
                <a href="{{ route('admin.informes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Criar Primeiro Informe
                </a>
            </div>
        @endforelse
    </div>
</div>

<!-- Paginação -->
@if($informes->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $informes->appends(request()->query())->links() }}
    </div>
@endif

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o informe <strong id="informeTitle"></strong>?</p>
                <p class="text-muted small">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmarExclusao(id, title) {
    document.getElementById('informeTitle').textContent = title;
    document.getElementById('deleteForm').action = `/admin/informes/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
@endsection


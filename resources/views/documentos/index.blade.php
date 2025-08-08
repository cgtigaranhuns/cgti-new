@extends('layouts.app')

@section('title', 'Documentos - CGTI IFPE Garanhuns')
@section('description', 'Acesse guias, normas, legislação e outros documentos da Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns.')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page">Documentos</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">Documentos</h1>
            <p class="lead text-muted">Guias, normas, legislação e outros documentos importantes</p>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto">
            <form method="GET" action="{{ route('documentos.index') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Buscar documentos..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="categoria" class="form-select">
                            <option value="">Todas as categorias</option>
                            @foreach(\App\Models\Documento::getCategorias() as $key => $nome)
                                <option value="{{ $key }}" {{ request('categoria') == $key ? 'selected' : '' }}>
                                    {{ $nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-cgti w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                
                @if(request('search') || request('categoria'))
                    <div class="mt-2">
                        <a href="{{ route('documentos.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-lg me-1"></i>Limpar filtros
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-5">
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 bg-primary text-white text-center">
                <div class="card-body py-3">
                    <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0">{{ $documentos->total() }}</h4>
                    <small>Documentos</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 bg-success text-white text-center">
                <div class="card-body py-3">
                    <i class="bi bi-folder" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0">{{ count(\App\Models\Documento::getCategorias()) }}</h4>
                    <small>Categorias</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 bg-info text-white text-center">
                <div class="card-body py-3">
                    <i class="bi bi-download" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0">{{ \App\Models\Documento::sum('downloads') }}</h4>
                    <small>Downloads</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 bg-warning text-white text-center">
                <div class="card-body py-3">
                    <i class="bi bi-calendar-plus" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-0">{{ \App\Models\Documento::whereDate('created_at', '>=', now()->subDays(30))->count() }}</h4>
                    <small>Novos (30d)</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Documentos -->
    <div class="row">
        @forelse($documentos as $documento)
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 document-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <!-- Ícone do arquivo -->
                            <div class="me-3">
                                <div class="file-icon">
                                    <i class="bi {{ $documento->arquivo_icone }} text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                            
                            <!-- Informações -->
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-2">
                                    <a href="{{ route('documentos.show', $documento) }}" 
                                       class="text-decoration-none text-dark hover-primary">
                                        {{ $documento->titulo }}
                                    </a>
                                </h5>
                                
                                <div class="mb-2">
                                    <span class="badge bg-primary">
                                        {{ \App\Models\Documento::getCategorias()[$documento->categoria] }}
                                    </span>
                                </div>
                                
                                @if($documento->descricao)
                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit($documento->descricao, 100) }}
                                    </p>
                                @endif
                                
                                <!-- Meta informações -->
                                <div class="small text-muted mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <i class="bi bi-file-earmark me-1"></i>
                                            {{ $documento->arquivo_tamanho_formatado }}
                                        </div>
                                        <div class="col-6">
                                            <i class="bi bi-download me-1"></i>
                                            {{ $documento->downloads }} downloads
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $documento->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                                
                                <!-- Ações -->
                                <div class="d-flex gap-2">
                                    <a href="{{ route('documentos.download', $documento) }}" 
                                       class="btn btn-cgti btn-sm">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                    <a href="{{ route('documentos.show', $documento) }}" 
                                       class="btn btn-outline-cgti btn-sm">
                                        <i class="bi bi-eye me-1"></i>Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-file-earmark-text text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-muted">Nenhum documento encontrado</h4>
                    <p class="text-muted">
                        @if(request('search') || request('categoria'))
                            Não encontramos documentos com os filtros aplicados.
                        @else
                            Ainda não há documentos disponíveis.
                        @endif
                    </p>
                    @if(request('search') || request('categoria'))
                        <a href="{{ route('documentos.index') }}" class="btn btn-cgti">
                            Ver todos os documentos
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if($documentos->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $documentos->appends(request()->query())->links() }}
            </div>
        </div>
    @endif

    <!-- Informações Adicionais -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-light rounded-4 p-4">
                <h4 class="fw-bold text-primary mb-3">
                    <i class="bi bi-info-circle me-2"></i>Informações Importantes
                </h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold">Formatos Suportados</h6>
                        <p class="mb-0 text-muted">PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold">Precisa de Ajuda?</h6>
                        <p class="mb-0 text-muted">
                            <a href="{{ route('contato') }}" class="text-decoration-none">
                                Entre em contato conosco
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.document-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.document-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12) !important;
}

.file-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 12px;
}

.hover-primary:hover {
    color: var(--bs-primary) !important;
}
</style>
@endpush
@endsection


@extends('layouts.app')

@section('title', $documento->titulo . ' - Documentos CGTI')
@section('description', $documento->descricao ?: 'Documento da CGTI IFPE Garanhuns')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('documentos.index') }}">Documentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($documento->titulo, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Conteúdo Principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Cabeçalho -->
                    <div class="d-flex align-items-start mb-4">
                        <div class="me-4">
                            <div class="file-icon-large">
                                <i class="bi {{ $documento->arquivo_icone }} text-primary" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h1 class="fw-bold text-primary mb-3">{{ $documento->titulo }}</h1>
                            <div class="mb-3">
                                <span class="badge bg-primary fs-6">
                                    {{ \App\Models\Documento::getCategorias()[$documento->categoria] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Descrição -->
                    @if($documento->descricao)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Descrição</h5>
                            <p class="text-muted lh-lg">{{ $documento->descricao }}</p>
                        </div>
                    @endif
                    
                    <!-- Informações do Arquivo -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Informações do Arquivo</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark text-primary me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h6 class="mb-0">Nome do Arquivo</h6>
                                        <small class="text-muted">{{ $documento->arquivo_nome }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-hdd text-primary me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h6 class="mb-0">Tamanho</h6>
                                        <small class="text-muted">{{ $documento->arquivo_tamanho_formatado }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-download text-primary me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h6 class="mb-0">Downloads</h6>
                                        <small class="text-muted">{{ $documento->downloads }} vezes</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar3 text-primary me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <h6 class="mb-0">Publicado em</h6>
                                        <small class="text-muted">{{ $documento->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ações -->
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="{{ route('documentos.download', $documento) }}" 
                           class="btn btn-cgti btn-lg">
                            <i class="bi bi-download me-2"></i>Baixar Documento
                        </a>
                        <button class="btn btn-outline-cgti btn-lg" onclick="compartilharDocumento()">
                            <i class="bi bi-share me-2"></i>Compartilhar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Documentos Relacionados -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-files me-2"></i>Documentos Relacionados
                    </h6>
                </div>
                <div class="card-body p-0">
                    @php
                        $relacionados = \App\Models\Documento::ativo()
                            ->where('categoria', $documento->categoria)
                            ->where('id', '!=', $documento->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @forelse($relacionados as $relacionado)
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-start">
                                <i class="bi {{ $relacionado->arquivo_icone }} text-primary me-2" style="font-size: 1.2rem;"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="{{ route('documentos.show', $relacionado) }}" 
                                           class="text-decoration-none text-dark hover-primary">
                                            {{ Str::limit($relacionado->titulo, 50) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        {{ $relacionado->arquivo_tamanho_formatado }} • 
                                        {{ $relacionado->downloads }} downloads
                                    </small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted">
                            <i class="bi bi-files mb-2" style="font-size: 2rem;"></i>
                            <p class="mb-0">Nenhum documento relacionado</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Categorias -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-folder me-2"></i>Outras Categorias
                    </h6>
                </div>
                <div class="card-body">
                    @foreach(\App\Models\Documento::getCategorias() as $key => $nome)
                        @if($key !== $documento->categoria)
                            <a href="{{ route('documentos.index', ['categoria' => $key]) }}" 
                               class="btn btn-outline-secondary btn-sm mb-2 me-2">
                                {{ $nome }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Voltar para lista -->
    <div class="row mt-5">
        <div class="col-12 text-center">
            <a href="{{ route('documentos.index') }}" class="btn btn-cgti">
                <i class="bi bi-arrow-left me-2"></i>Voltar para Documentos
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
.file-icon-large {
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 20px;
}

.hover-primary:hover {
    color: var(--bs-primary) !important;
}

@media (max-width: 768px) {
    .file-icon-large {
        width: 80px;
        height: 80px;
    }
    
    .file-icon-large i {
        font-size: 3rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
function compartilharDocumento() {
    const titulo = @json($documento->titulo);
    const url = window.location.href;
    
    if (navigator.share) {
        navigator.share({
            title: titulo,
            text: `Confira este documento da CGTI: ${titulo}`,
            url: url
        });
    } else {
        // Fallback para navegadores que não suportam Web Share API
        navigator.clipboard.writeText(url).then(function() {
            // Mostrar feedback visual
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check me-2"></i>Link Copiado!';
            btn.classList.remove('btn-outline-cgti');
            btn.classList.add('btn-success');
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-cgti');
            }, 2000);
        });
    }
}
</script>
@endpush
@endsection


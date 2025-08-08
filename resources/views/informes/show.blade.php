@extends('layouts.app')

@section('title', $informe->title . ' - CGTI IFPE Garanhuns')
@section('description', $informe->excerpt ?: Str::limit(strip_tags($informe->content), 160))

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('informes.index') }}">Informes</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($informe->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Conteúdo Principal -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm">
                @if($informe->featured_image)
                    <img src="{{ asset('storage/' . $informe->featured_image) }}" 
                         class="card-img-top rounded-top" 
                         alt="{{ $informe->title }}"
                         style="height: 300px; object-fit: cover;">
                @endif
                
                <div class="card-body p-4">
                    <!-- Meta informações -->
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            Publicado em {{ $informe->published_at->format('d/m/Y') }} às {{ $informe->published_at->format('H:i') }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-eye me-1"></i>
                            {{ $informe->views }} visualizações
                            @if($informe->user)
                                <span class="mx-2">•</span>
                                <i class="bi bi-person me-1"></i>
                                {{ $informe->user->name }}
                            @endif
                        </small>
                    </div>
                    
                    <!-- Título -->
                    <h1 class="fw-bold text-primary mb-4">{{ $informe->title }}</h1>
                    
                    <!-- Excerpt -->
                    @if($informe->excerpt)
                        <div class="alert alert-light border-start border-primary border-4 mb-4">
                            <p class="mb-0 fw-medium">{{ $informe->excerpt }}</p>
                        </div>
                    @endif
                    
                    <!-- Conteúdo -->
                    <div class="content-body">
                        {!! nl2br(e($informe->content)) !!}
                    </div>
                </div>
            </article>
            
            <!-- Navegação entre posts -->
            <div class="row mt-4">
                <div class="col-6">
                    @php
                        $anterior = \App\Models\Informe::published()
                            ->where('published_at', '<', $informe->published_at)
                            ->orderBy('published_at', 'desc')
                            ->first();
                    @endphp
                    @if($anterior)
                        <a href="{{ route('informes.show', $anterior->slug) }}" 
                           class="btn btn-outline-cgti w-100 text-start">
                            <i class="bi bi-arrow-left me-2"></i>
                            <small class="d-block text-muted">Anterior</small>
                            {{ Str::limit($anterior->title, 40) }}
                        </a>
                    @endif
                </div>
                <div class="col-6">
                    @php
                        $proximo = \App\Models\Informe::published()
                            ->where('published_at', '>', $informe->published_at)
                            ->orderBy('published_at', 'asc')
                            ->first();
                    @endphp
                    @if($proximo)
                        <a href="{{ route('informes.show', $proximo->slug) }}" 
                           class="btn btn-outline-cgti w-100 text-end">
                            <small class="d-block text-muted">Próximo</small>
                            {{ Str::limit($proximo->title, 40) }}
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informes Recentes -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-newspaper me-2"></i>Informes Recentes
                    </h6>
                </div>
                <div class="card-body p-0">
                    @php
                        $recentes = \App\Models\Informe::published()
                            ->where('id', '!=', $informe->id)
                            ->orderBy('published_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @forelse($recentes as $recente)
                        <div class="p-3 border-bottom">
                            <h6 class="mb-1">
                                <a href="{{ route('informes.show', $recente->slug) }}" 
                                   class="text-decoration-none text-dark hover-primary">
                                    {{ Str::limit($recente->title, 60) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $recente->published_at->format('d/m/Y') }}
                            </small>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted">
                            <i class="bi bi-newspaper mb-2" style="font-size: 2rem;"></i>
                            <p class="mb-0">Nenhum outro informe disponível</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Ações -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-share me-2"></i>Compartilhar
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm" 
                                onclick="compartilharWhatsApp()">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp
                        </button>
                        <button class="btn btn-outline-info btn-sm" 
                                onclick="compartilharEmail()">
                            <i class="bi bi-envelope me-2"></i>Email
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" 
                                onclick="copiarLink()">
                            <i class="bi bi-link-45deg me-2"></i>Copiar Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Voltar para lista -->
    <div class="row mt-5">
        <div class="col-12 text-center">
            <a href="{{ route('informes.index') }}" class="btn btn-cgti">
                <i class="bi bi-arrow-left me-2"></i>Voltar para Informes
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
.content-body {
    line-height: 1.8;
    font-size: 1.1rem;
}

.content-body p {
    margin-bottom: 1.5rem;
}

.hover-primary:hover {
    color: var(--bs-primary) !important;
}
</style>
@endpush

@push('scripts')
<script>
function compartilharWhatsApp() {
    const titulo = @json($informe->title);
    const url = window.location.href;
    const texto = `Confira este informe da CGTI: ${titulo} - ${url}`;
    window.open(`https://wa.me/?text=${encodeURIComponent(texto)}`, '_blank');
}

function compartilharEmail() {
    const titulo = @json($informe->title);
    const url = window.location.href;
    const assunto = `Informe CGTI: ${titulo}`;
    const corpo = `Confira este informe da CGTI:\n\n${titulo}\n\n${url}`;
    window.location.href = `mailto:?subject=${encodeURIComponent(assunto)}&body=${encodeURIComponent(corpo)}`;
}

function copiarLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Mostrar feedback visual
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-2"></i>Copiado!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>
@endpush
@endsection


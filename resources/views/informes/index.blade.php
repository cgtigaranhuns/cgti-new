@extends('layouts.app')

@section('title', 'Informes - CGTI IFPE Garanhuns')
@section('description', 'Acompanhe os informes e notícias da Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns.')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page">Informes</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">Informes</h1>
            <p class="lead text-muted">Acompanhe as últimas notícias e informações da CGTI</p>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form method="GET" action="{{ route('informes.index') }}" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" 
                       placeholder="Buscar informes..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-cgti">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('informes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Lista de Informes -->
    <div class="row">
        @forelse($informes as $informe)
            <div class="col-lg-6 mb-4">
                <article class="card h-100 border-0 shadow-sm hover-lift">
                    @if($informe->featured_image)
                        <img src="{{ asset('storage/' . $informe->featured_image) }}" 
                             class="card-img-top" 
                             alt="{{ $informe->title }}"
                             style="height: 200px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $informe->published_at->format('d/m/Y') }}
                                <span class="mx-2">•</span>
                                <i class="bi bi-eye me-1"></i>
                                {{ $informe->views }} visualizações
                            </small>
                        </div>
                        
                        <h5 class="card-title fw-bold">
                            <a href="{{ route('informes.show', $informe->slug) }}" 
                               class="text-decoration-none text-dark hover-primary">
                                {{ $informe->title }}
                            </a>
                        </h5>
                        
                        @if($informe->excerpt)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($informe->excerpt, 120) }}
                            </p>
                        @endif
                        
                        <div class="mt-auto">
                            <a href="{{ route('informes.show', $informe->slug) }}" 
                               class="btn btn-outline-cgti btn-sm">
                                Ler mais <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-newspaper text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-muted">Nenhum informe encontrado</h4>
                    <p class="text-muted">
                        @if(request('search'))
                            Não encontramos informes com o termo "{{ request('search') }}".
                        @else
                            Ainda não há informes publicados.
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('informes.index') }}" class="btn btn-cgti">
                            Ver todos os informes
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if($informes->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $informes->links() }}
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.hover-primary:hover {
    color: var(--bs-primary) !important;
}
</style>
@endpush
@endsection


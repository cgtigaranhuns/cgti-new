@extends('layouts.app')

@section('title', 'Processos - CGTI IFPE Garanhuns')
@section('description', 'Acesse os processos e procedimentos das diversas coordenações do IFPE Campus Garanhuns.')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page">Processos</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">Processos</h1>
            <p class="lead text-muted">Procedimentos e processos das coordenações do IFPE Campus Garanhuns</p>
        </div>
    </div>

    <!-- Filtros e Busca -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto">
            <form method="GET" action="{{ route('processos.index') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Buscar processos..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="categoria" class="form-select">
                            <option value="">Todas as coordenações</option>
                            @foreach(\App\Models\Processo::getCategorias() as $key => $nome)
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
                        <a href="{{ route('processos.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-x-lg me-1"></i>Limpar filtros
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Coordenações em Destaque -->
    @if(!request('search') && !request('categoria'))
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="fw-bold text-primary mb-4 text-center">Coordenações</h3>
                <div class="row">
                    @foreach(\App\Models\Processo::getCategorias() as $key => $nome)
                        @php
                            $count = \App\Models\Processo::ativo()->categoria($key)->count();
                        @endphp
                        @if($count > 0)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                <a href="{{ route('processos.index', ['categoria' => $key]) }}" 
                                   class="text-decoration-none">
                                    <div class="card border-0 shadow-sm h-100 coord-card">
                                        <div class="card-body text-center p-4">
                                            <div class="coord-icon mb-3">
                                                <i class="bi bi-building text-primary" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark mb-2">{{ $nome }}</h6>
                                            <span class="badge bg-primary">{{ $count }} processos</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Lista de Processos -->
    <div class="row">
        @forelse($processos as $processo)
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 process-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <!-- Ícone do arquivo -->
                            <div class="me-3">
                                <div class="file-icon">
                                    <i class="bi bi-file-earmark-text text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                            
                            <!-- Informações -->
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-2">
                                    <a href="{{ route('processos.show', $processo) }}" 
                                       class="text-decoration-none text-dark hover-primary">
                                        {{ $processo->titulo }}
                                    </a>
                                </h5>
                                
                                <div class="mb-2">
                                    <span class="badge bg-primary">
                                        {{ \App\Models\Processo::getCategorias()[$processo->categoria] }}
                                    </span>
                                </div>
                                
                                @if($processo->descricao)
                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit($processo->descricao, 100) }}
                                    </p>
                                @endif
                                
                                <!-- Meta informações -->
                                <div class="small text-muted mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <i class="bi bi-file-earmark me-1"></i>
                                            {{ $processo->arquivo_tamanho_formatado }}
                                        </div>
                                        <div class="col-6">
                                            <i class="bi bi-download me-1"></i>
                                            {{ $processo->downloads }} downloads
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $processo->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                                
                                <!-- Ações -->
                                <div class="d-flex gap-2">
                                    <a href="{{ route('processos.download', $processo) }}" 
                                       class="btn btn-cgti btn-sm">
                                        <i class="bi bi-download me-1"></i>Download
                                    </a>
                                    <a href="{{ route('processos.show', $processo) }}" 
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
                    <h4 class="text-muted">Nenhum processo encontrado</h4>
                    <p class="text-muted">
                        @if(request('search') || request('categoria'))
                            Não encontramos processos com os filtros aplicados.
                        @else
                            Ainda não há processos disponíveis.
                        @endif
                    </p>
                    @if(request('search') || request('categoria'))
                        <a href="{{ route('processos.index') }}" class="btn btn-cgti">
                            Ver todos os processos
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if($processos->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $processos->appends(request()->query())->links() }}
            </div>
        </div>
    @endif

    <!-- Informações Adicionais -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-light rounded-4 p-4">
                <h4 class="fw-bold text-primary mb-3">
                    <i class="bi bi-info-circle me-2"></i>Sobre os Processos
                </h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold">O que são?</h6>
                        <p class="mb-0 text-muted">
                            Documentos que descrevem procedimentos e fluxos de trabalho 
                            das diversas coordenações do campus.
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="fw-bold">Como usar?</h6>
                        <p class="mb-0 text-muted">
                            Baixe os documentos para consultar os procedimentos específicos 
                            de cada coordenação.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.process-card,
.coord-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.process-card:hover,
.coord-card:hover {
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

.coord-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 50%;
}

.hover-primary:hover {
    color: var(--bs-primary) !important;
}
</style>
@endpush
@endsection


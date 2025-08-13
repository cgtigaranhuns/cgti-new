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


    <!-- Coordenações em Destaque -->

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
                    <a href="{{ route('processos.por-coordenacao', ['categoria' => $key]) }}"
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
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
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
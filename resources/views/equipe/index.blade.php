@extends('layouts.app')

@section('title', 'Equipe - CGTI IFPE Garanhuns')
@section('description', 'Conheça a equipe da Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns.')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page">Equipe</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">Nossa Equipe</h1>
            <p class="lead text-muted">Conheça os profissionais que fazem a CGTI funcionar</p>
        </div>
    </div>

    <!-- Membros da Equipe -->
    <div class="row">
        @forelse($membros as $membro)
            <div class="col-lg-6 mb-5">
                <div class="card border-0 shadow-sm h-100 team-card">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Foto -->
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <div class="team-photo-container">
                                    @if($membro->foto)
                                        <img src="{{ $membro->foto_url }}" 
                                             alt="{{ $membro->nome }}"
                                             class="team-photo">
                                    @else
                                        <div class="team-photo-placeholder">
                                            <span class="initials">{{ $membro->nome_inicial }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Informações -->
                            <div class="col-md-8">
                                <h4 class="fw-bold text-primary mb-2">{{ $membro->nome }}</h4>
                                <h6 class="text-muted mb-3">{{ $membro->cargo }}</h6>
                                
                                @if($membro->formacao)
                                    <div class="mb-3">
                                        <h6 class="fw-bold mb-1">
                                            <i class="bi bi-mortarboard text-primary me-2"></i>Formação
                                        </h6>
                                        <p class="mb-0 text-muted">{{ $membro->formacao }}</p>
                                    </div>
                                @endif
                                
                                @if($membro->conhecimentos)
                                    <div class="mb-3">
                                        <h6 class="fw-bold mb-1">
                                            <i class="bi bi-gear text-primary me-2"></i>Conhecimentos
                                        </h6>
                                        <p class="mb-0 text-muted">{{ Str::limit($membro->conhecimentos, 150) }}</p>
                                    </div>
                                @endif
                                
                                <!-- Contatos -->
                                <div class="d-flex gap-2 mt-3">
                                    @if($membro->email)
                                        <a href="mailto:{{ $membro->email }}" 
                                           class="btn btn-outline-primary btn-sm"
                                           title="Email">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                    @endif
                                    @if($membro->telefone)
                                        <a href="tel:{{ $membro->telefone }}" 
                                           class="btn btn-outline-primary btn-sm"
                                           title="Telefone">
                                            <i class="bi bi-telephone"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($membro->bio)
                            <div class="mt-4 pt-3 border-top">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-person text-primary me-2"></i>Sobre
                                </h6>
                                <p class="mb-0 text-muted">{{ $membro->bio }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-muted">Equipe em construção</h4>
                    <p class="text-muted">As informações da equipe serão disponibilizadas em breve.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Informações Adicionais -->
    @if($membros->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <div class="bg-light rounded-4 p-5 text-center">
                    <h3 class="fw-bold text-primary mb-3">Quer fazer parte da nossa equipe?</h3>
                    <p class="mb-4 text-muted">
                        A CGTI está sempre em busca de profissionais qualificados e dedicados. 
                        Acompanhe os processos seletivos do IFPE e venha trabalhar conosco!
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="https://www.ifpe.edu.br/concursos-e-seletivos" 
                           target="_blank" 
                           class="btn btn-cgti">
                            <i class="bi bi-briefcase me-2"></i>Ver Oportunidades
                        </a>
                        <a href="{{ route('contato') }}" class="btn btn-outline-cgti">
                            <i class="bi bi-envelope me-2"></i>Entre em Contato
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.team-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.team-photo-container {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto;
}

.team-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--bs-primary);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.team-photo-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--bs-primary), var(--bs-primary-dark, #084298));
    display: flex;
    align-items: center;
    justify-content: center;
    border: 4px solid var(--bs-primary);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.initials {
    color: white;
    font-size: 2rem;
    font-weight: bold;
}

@media (max-width: 768px) {
    .team-photo,
    .team-photo-placeholder {
        width: 100px;
        height: 100px;
    }
    
    .team-photo-container {
        width: 100px;
        height: 100px;
    }
    
    .initials {
        font-size: 1.5rem;
    }
}
</style>
@endpush
@endsection


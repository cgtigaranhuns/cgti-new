@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Cards de Estatísticas -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-uppercase mb-1 opacity-75">Informes</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['informes']['total'] }}</h2>
                        <small class="opacity-75">{{ $stats['informes']['publicados'] }} publicados</small>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-newspaper" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <small class="opacity-75">
                    <i class="bi bi-plus-circle me-1"></i>{{ $stats['informes']['este_mes'] }} este mês
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-uppercase mb-1 opacity-75">Documentos</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['documentos']['total'] }}</h2>
                        <small class="opacity-75">{{ $stats['documentos']['downloads'] }} downloads</small>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-file-earmark-text" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <small class="opacity-75">
                    <i class="bi bi-plus-circle me-1"></i>{{ $stats['documentos']['este_mes'] }} este mês
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-uppercase mb-1 opacity-75">Processos</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['processos']['total'] }}</h2>
                        <small class="opacity-75">{{ $stats['processos']['downloads'] }} downloads</small>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-diagram-3" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <small class="opacity-75">
                    <i class="bi bi-plus-circle me-1"></i>{{ $stats['processos']['este_mes'] }} este mês
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-uppercase mb-1 opacity-75">Equipe</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['equipe']['total'] }}</h2>
                        <small class="opacity-75">{{ $stats['equipe']['ativos'] }} ativos</small>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-people" style="font-size: 2.5rem; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <small class="opacity-75">
                    <i class="bi bi-plus-circle me-1"></i>{{ $stats['equipe']['este_mes'] }} este mês
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Atividades Recentes -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history text-primary me-2"></i>Atividades Recentes
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="row g-0">
                    <!-- Informes Recentes -->
                    <div class="col-md-6 border-end">
                        <div class="p-3 border-bottom bg-light">
                            <h6 class="mb-0 fw-bold text-primary">
                                <i class="bi bi-newspaper me-2"></i>Informes Recentes
                            </h6>
                        </div>
                        @forelse($informes_recentes as $informe)
                            <div class="p-3 border-bottom">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.informes.edit', $informe) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ Str::limit($informe->title, 40) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-person me-1"></i>{{ $informe->user->name ?? 'Sistema' }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-calendar3 me-1"></i>{{ $informe->created_at->format('d/m/Y H:i') }}
                                </small>
                                @if($informe->published)
                                    <span class="badge bg-success ms-2">Publicado</span>
                                @else
                                    <span class="badge bg-warning ms-2">Rascunho</span>
                                @endif
                            </div>
                        @empty
                            <div class="p-3 text-center text-muted">
                                <i class="bi bi-newspaper mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Nenhum informe recente</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Documentos Recentes -->
                    <div class="col-md-6">
                        <div class="p-3 border-bottom bg-light">
                            <h6 class="mb-0 fw-bold text-success">
                                <i class="bi bi-file-earmark-text me-2"></i>Documentos Recentes
                            </h6>
                        </div>
                        @forelse($documentos_recentes as $documento)
                            <div class="p-3 border-bottom">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.documentos.edit', $documento) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ Str::limit($documento->titulo, 40) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-person me-1"></i>{{ $documento->user->name ?? 'Sistema' }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-download me-1"></i>{{ $documento->downloads }}
                                </small>
                                @if($documento->ativo)
                                    <span class="badge bg-success ms-2">Ativo</span>
                                @else
                                    <span class="badge bg-secondary ms-2">Inativo</span>
                                @endif
                            </div>
                        @empty
                            <div class="p-3 text-center text-muted">
                                <i class="bi bi-file-earmark-text mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-0">Nenhum documento recente</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Ações Rápidas -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-lightning text-warning me-2"></i>Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.informes.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Novo Informe
                    </a>
                    <a href="{{ route('admin.documentos.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Novo Documento
                    </a>
                    <a href="{{ route('admin.processos.create') }}" class="btn btn-info">
                        <i class="bi bi-plus-circle me-2"></i>Novo Processo
                    </a>
                    <a href="{{ route('admin.equipe.create') }}" class="btn btn-warning">
                        <i class="bi bi-plus-circle me-2"></i>Novo Membro
                    </a>
                </div>
                
                <hr class="my-3">
                
                <div class="d-grid gap-2">
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Ver Site
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Documentos Mais Baixados -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-trophy text-warning me-2"></i>Documentos Mais Baixados
                </h5>
            </div>
            <div class="card-body p-0">
                @forelse($documentos_populares as $index => $documento)
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="badge bg-primary rounded-pill">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.documentos.edit', $documento) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ Str::limit($documento->titulo, 35) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-download me-1"></i>{{ $documento->downloads }} downloads
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-folder me-1"></i>{{ \App\Models\Documento::getCategorias()[$documento->categoria] }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">
                        <i class="bi bi-file-earmark-text mb-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">Nenhum documento disponível</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Processos Mais Baixados -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-trophy text-info me-2"></i>Processos Mais Baixados
                </h5>
            </div>
            <div class="card-body p-0">
                @forelse($processos_populares as $index => $processo)
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="badge bg-info rounded-pill">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.processos.edit', $processo) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ Str::limit($processo->titulo, 35) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-download me-1"></i>{{ $processo->downloads }} downloads
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-building me-1"></i>{{ \App\Models\Processo::getCategorias()[$processo->categoria] }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">
                        <i class="bi bi-diagram-3 mb-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">Nenhum processo disponível</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection


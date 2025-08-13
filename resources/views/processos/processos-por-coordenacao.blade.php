@extends('layouts.app')

@section('title', 'Processos por Coordenação - CGTI IFPE Garanhuns')
@section('description', 'Processos específicos da coordenação selecionada')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item"><a href="{{ route('processos.index') }}">Processos</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ \App\Models\Processo::getCategorias()[$categoria] }}</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <div class="coord-icon-large">
                        <i class="bi bi-building text-primary" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <div>
                    <h1 class="fw-bold text-primary mb-2">{{ \App\Models\Processo::getCategorias()[$categoria] }}</h1>
                    <p class="lead text-muted mb-0">{{ $processos->total() }} processos disponíveis</p>
                </div>
            </div>
        </div>
    </div>

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
                                <i class="bi bi-diagram-3 text-primary" style="font-size: 2.5rem;"></i>
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

                            @if($processo->descricao)
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit($processo->descricao, 100) }}
                            </p>
                            @endif

                            <!-- Meta informações -->
                            <div class="small text-muted mb-3">

                                <div class="mt-1">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $processo->created_at->format('d/m/Y') }}
                                </div>
                            </div>

                            <!-- Ações -->
                            <div class="d-flex gap-2">

                                <button type="button" class="btn btn-outline-cgti btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalDiagrama" data-diagrama-url="{{ $processo->arquivo_url }}"
                                    data-titulo="{{ $processo->titulo }}">
                                    <i class="bi bi-eye me-1"></i>Diagrama
                                </button>
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
                    Não há processos disponíveis para esta coordenação.
                </p>
                <a href="{{ route('processos.index') }}" class="btn btn-cgti mt-3">
                    <i class="bi bi-arrow-left me-2"></i>Voltar para todos os processos
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if($processos->hasPages())
    <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
            {{ $processos->appends(['categoria' => $categoria])->links() }}
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
.coord-icon-large {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 20px;
}

.process-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.process-card:hover {
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

.hover-primary:hover {
    color: var(--bs-primary) !important;
}
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const img = document.getElementById('modal-diagrama-img');
    const container = document.getElementById('zoom-container');

    let scale = 1;
    let isDragging = false;
    let startX, startY, translateX = 0,
        translateY = 0;

    // Zoom com roda do mouse
    container.addEventListener('wheel', function(e) {
        e.preventDefault();
        const delta = e.deltaY > 0 ? -0.1 : 0.1;
        scale = Math.min(Math.max(1, scale + delta), 5); // limite de 1x a 5x
        updateTransform();
    });

    // Arrastar com mouse
    container.addEventListener('mousedown', function(e) {
        if (scale > 1) {
            isDragging = true;
            startX = e.clientX - translateX;
            startY = e.clientY - translateY;
            container.style.cursor = 'grabbing';
        }
    });

    container.addEventListener('mouseup', function() {
        isDragging = false;
        container.style.cursor = 'grab';
    });

    container.addEventListener('mouseleave', function() {
        isDragging = false;
        container.style.cursor = 'grab';
    });

    container.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        translateX = e.clientX - startX;
        translateY = e.clientY - startY;
        updateTransform();
    });

    // Toque e movimento no celular (pinch simplificado)
    let initialDistance = 0;
    container.addEventListener('touchstart', function(e) {
        if (e.touches.length === 2) {
            initialDistance = getDistance(e.touches);
        }
    });

    container.addEventListener('touchmove', function(e) {
        if (e.touches.length === 2) {
            const newDistance = getDistance(e.touches);
            const delta = (newDistance - initialDistance) / 200;
            scale = Math.min(Math.max(1, scale + delta), 5);
            initialDistance = newDistance;
            updateTransform();
        }
    });

    function getDistance(touches) {
        const dx = touches[0].clientX - touches[1].clientX;
        const dy = touches[0].clientY - touches[1].clientY;
        return Math.sqrt(dx * dx + dy * dy);
    }

    function updateTransform() {
        img.style.transform = `scale(${scale}) translate(${translateX / scale}px, ${translateY / scale}px)`;
    }

    // Reset ao abrir o modal
    document.getElementById('modalDiagrama').addEventListener('show.bs.modal', function() {
        scale = 1;
        translateX = 0;
        translateY = 0;
        updateTransform();
    });
});
</script>
@endpush


@push('scripts')
<script>
// Preenche o modal quando for aberto pelo Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('modalDiagrama');
    const imgEl = document.getElementById('modal-diagrama-img');
    const titleEl = document.getElementById('modalDiagramaLabel');

    if (modalEl) {
        modalEl.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const url = button?.getAttribute('data-diagrama-url') || '';
            const titulo = button?.getAttribute('data-titulo') || 'Diagrama';
            if (imgEl) imgEl.src = url;
            if (titleEl) titleEl.textContent = titulo;
        });
    }
    /*
        // Fallback: se Bootstrap JS não estiver presente, abrir em nova aba
        if (!window.bootstrap) {
            document.querySelectorAll('[data-diagrama-url]').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = btn.getAttribute('data-diagrama-url');
                    if (url) window.open(url, '_blank');
                });
            });
        }*/
});
</script>
@endpush

<!-- Modal para exibir diagrama -->
<div class="modal fade" id="modalDiagrama" tabindex="-1" aria-labelledby="modalDiagramaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-white border-0 shadow-lg rounded">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-primary" id="modalDiagramaLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center" id="zoom-container" style="overflow: hidden; cursor: grab;">
                <img id="modal-diagrama-img" src="" alt="Diagrama" class="img-fluid rounded shadow-sm"
                    style="transition: transform 0.2s ease;">
            </div>
        </div>
    </div>
</div>
@endsection
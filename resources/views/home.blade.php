@extends('layouts.app')

@section('title', 'CGTI - Coordenação de Gestão de Tecnologia da Informação')
@section('description', 'Portal da Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns. Acesse
nossos serviços e sistemas.')

@section('content')
<div class="container">
    <!-- Hero Section 
    <section class="row mb-5">
        <div class="col-12">
            <div class="hero-section p-5 text-center fade-in-up">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold text-primary mb-3">
                        Bem-vindo à CGTI
                    </h1>
                    <p class="lead mb-4">
                        Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns.
                        Oferecemos soluções tecnológicas e serviços digitais para a comunidade acadêmica.
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="#servicos" class="btn btn-cgti btn-lg">
                            <i class="bi bi-grid-3x3-gap me-2"></i>Ver Serviços
                        </a>
                        <a href="{{ route('contato') }}" class="btn btn-outline-cgti btn-lg">
                            <i class="bi bi-envelope me-2"></i>Entre em Contato
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>-->

    <!-- Serviços Principais -->
    <section id="servicos" class="mb-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3">Nossos Serviços</h2>
                <p class="lead text-muted">Acesse os principais sistemas e serviços da CGTI</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($servicos as $servico)
            <div class="col-md-6 col-lg-4">
                <div class="card service-card h-100">
                    <div class="card-body">
                        <div class="service-icon">
                            <!-- Substitui o ícone do Bootstrap por uma imagem -->
                            <img src="{{ asset(('storage/' .$servico->icon ?? 'default'))}}" alt="{{ $servico->name }}"
                                style="width: 70px; height: 70px;">
                        </div>
                        <h5 class="card-title">{{ $servico->name }}</h5>
                        <p class="card-text text-muted">{{ $servico->description }}</p>
                        <a href="{{ $servico->url }}" target="_blank" class="btn btn-service">
                            Acessar <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Serviços Internos -->
    @if($servicosInternos->count() > 0)
    <section class="mb-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 class="fw-bold mb-3">Serviços Internos</h3>
                <p class="text-muted">Serviços disponíveis na rede interna do campus</p>
            </div>
        </div>

        <div class="row g-3">
            @foreach($servicosInternos as $servico)
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 bg-light h-100">
                    <div class="card-body text-center">
                        <!-- Substitui o ícone do Bootstrap por uma imagem -->
                        <img src="{{ asset(('storage/' . $servico->icon ?? 'default'))}}" alt="{{ $servico->name }}"
                            style="width: 70px; height: 70px;">
                        <h6 class="card-title">{{ $servico->name }}</h6>
                        <a href="{{ $servico->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            Acessar
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Informes Recentes -->
    @if($informes->count() > 0)
    <section class="mb-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="fw-bold mb-0">Informes Recentes</h3>
                    <a href="{{ route('informes.index') }}" class="btn btn-outline-primary">
                        Ver Todos <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($informes as $informe)
            <div class="col-md-6 col-lg-4">
                <article class="card info-card h-100">
                    @if($informe->featured_image)
                    <img src="{{ Storage::url($informe->featured_image) }}" class="card-img-top"
                        alt="{{ $informe->title }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('informes.show', $informe->slug) }}" class="text-decoration-none">
                                {{ $informe->title }}
                            </a>
                        </h5>
                        @if($informe->excerpt)
                        <p class="card-text text-muted">{{ $informe->excerpt }}</p>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                {{ $informe->published_at->format('d/m/Y') }}
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-eye me-1"></i>
                                {{ $informe->views }} visualizações
                            </small>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Call to Action >
    <section class="mb-5">
        <div class="row">
            <div class="col-12">
                <div class="bg-primary text-white rounded-4 p-5 text-center">
                    <h3 class="fw-bold mb-3">Precisa de Ajuda?</h3>
                    <p class="mb-4">Nossa equipe está pronta para atendê-lo. Entre em contato conosco!</p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{ route('contato') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-envelope me-2"></i>Enviar Mensagem
                        </a>
                        <a href="tel:+558737611000" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-telephone me-2"></i>(87) 3761-1000
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
</div>

@push('scripts')
<script>
// Smooth scroll para âncoras
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Animação de entrada para cards
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-up');
        }
    });
}, observerOptions);

document.querySelectorAll('.service-card, .info-card').forEach(card => {
    observer.observe(card);
});
</script>
@endpush
@endsection
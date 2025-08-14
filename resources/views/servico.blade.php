@extends('layouts.app')

@section('title', 'CGTI - Coordenação de Gestão de Tecnologia da Informação')
@section('description', 'Portal da Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns. Acesse
nossos serviços e sistemas.')

<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'> </script>

@section('content')
<div class="container">
    <!-- Hero Section -->
    <section class="row mb-5">
        <div class="col-12">
            <div class="hero-section p-5 text-center fade-in-up">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold text-primary mb-3">
                        Serviços Digitais
                    </h1>

                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="#garanhuns" class="btn btn-cgti btn-lg">
                            <i class="bi bi-globe me-2"></i>Sistemas da CGTI
                        </a>
                        <a href="#internos" class="btn btn-cgti btn-lg">
                            <i class="bi bi-joystick me-2"></i>Sistemas da Intranet
                        </a>
                        <a href="#institucional" class="btn btn-cgti btn-lg">
                            <i class="bi bi-info-lg me-2"></i>Sistemas Institucionais
                        </a>
                        <a href="#governamental" class="btn btn-cgti btn-lg">
                            <i class="bi bi-google me-2"></i>Sistemas Governamentais
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços Principais -->
    <section class="mb-5" id="garanhuns">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3">Nossos Serviços - Campus Garanhuns</h2>
                <p class="text-muted">Acesse os principais sistemas e serviços da CGTI</p>
            </div>
        </div>

        <div class="row g-3">
            @foreach($servicos as $servico)
            <div class="col-md-6 col-lg-3">
                <div class="card service-card h-100">
                    <div class="card-body">
                        <div class="service-icon">
                            <!-- Substitui o ícone do Bootstrap por uma imagem -->
                            <img src="{{asset(('storage/' . $servico->icon ?? 'default'))}}" alt="{{ $servico->name }}"
                                style="width: 70px; height: 70px;">
                        </div>
                        <h5 class="card-title">{{ $servico->name }}</h5>
                        <p class="card-text text-muted">{{ $servico->description }}</p>
                        <a href="{{ $servico->url }}" target="_blank" class="btn btn-service mt-auto">
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
    <section class="mb-5" id="internos">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 class="fw-bold mb-3">Serviços Internos</h3>
                <p class="text-muted">Serviços disponíveis na rede interna do campus</p>
            </div>
        </div>

        <div class="row g-3">
            @foreach($servicosInternos as $servico)
            <div class="col-md-6 col-lg-3">
                <div class="card service-card h-100">
                    <div class="card-body">
                        <div class="service-icon">
                            <!-- Substitui o ícone do Bootstrap por uma imagem -->
                            <img src="{{asset(('storage/' . $servico->icon ?? 'default'))}}" alt="{{ $servico->name }}"
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
    @endif

    <!-- Serviços Institucionais -->
    @if($servicosInstitucional->count() > 0)
    <section class="mb-5" id="institucional">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 class="fw-bold mb-3">Sistemas Institucionais</h3>
                <p class="text-muted">Acesso aos sistemas e serviços institucionais</p>
            </div>
        </div>

        <div class="row g-3">
            @foreach($servicosInstitucional as $servico)
            <div class="col-md-6 col-lg-3">
                <div class="card service-card h-100">
                    <div class="card-body">
                        <div class="service-icon">
                            <!-- Substitui o ícone do Bootstrap por uma imagem -->
                            <img src="{{asset(('storage/' . $servico->icon ?? 'default'))}}" alt="{{ $servico->name }}"
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
    @endif
    <!-- Serviços governamentais -->
    @if($servicosGovernamental->count() > 0)
    <section class="mb-5" id="governamental">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h3 class="fw-bold mb-3">Sistemas Governamentais</h3>
                <p class="text-muted">Acesso aos sistemas e serviços Governamentais</p>
            </div>
        </div>

        <div class="row g-3">
            @foreach($servicosGovernamental as $servico)
            <div class="col-md-6 col-lg-3">
                <div class="card service-card h-100">
                    <div class="card-body">
                        <div class="service-icon">
                            <!-- Substitui o ícone do Bootstrap por uma imagem -->
                            <img src="{{asset(('storage/' . $servico->icon ?? 'default'))}}" alt="{{ $servico->name }}"
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
    @endif
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
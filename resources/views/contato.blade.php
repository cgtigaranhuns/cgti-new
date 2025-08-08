@extends('layouts.app')

@section('title', 'Contato - CGTI IFPE Garanhuns')
@section('description', 'Entre em contato com a CGTI do IFPE Campus Garanhuns. Endereço, telefone, email e formulário de contato.')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contato</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">Entre em Contato</h1>
            <p class="lead text-muted">Estamos aqui para ajudá-lo. Entre em contato conosco!</p>
        </div>
    </div>

    <div class="row">
        <!-- Informações de Contato -->
        <div class="col-lg-4 mb-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="text-primary fw-bold mb-4">Informações de Contato</h3>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="text-primary me-3">
                                <i class="bi bi-geo-alt-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Endereço</h6>
                                <p class="mb-0 text-muted">
                                    BR 232, Km 208, s/n - Zona Rural<br>
                                    Garanhuns - PE<br>
                                    CEP: 55.292-270
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="text-primary me-3">
                                <i class="bi bi-telephone-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Telefone</h6>
                                <p class="mb-0">
                                    <a href="tel:+558737611000" class="text-decoration-none">(87) 3761-1000</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="text-primary me-3">
                                <i class="bi bi-envelope-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email</h6>
                                <p class="mb-0">
                                    <a href="mailto:cgti@garanhuns.ifpe.edu.br" class="text-decoration-none">
                                        cgti@garanhuns.ifpe.edu.br
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <div class="text-primary me-3">
                                <i class="bi bi-clock-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Horário de Funcionamento</h6>
                                <p class="mb-1"><strong>Segunda a Sexta:</strong> 07:00 às 17:00</p>
                                <p class="mb-0 text-muted"><strong>Sábados e Domingos:</strong> Fechado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário de Contato -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-primary fw-bold mb-4">Envie uma Mensagem</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('contato.enviar') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label fw-bold">Nome Completo *</label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" name="nome" value="{{ old('nome') }}" required>
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="assunto" class="form-label fw-bold">Assunto *</label>
                            <input type="text" class="form-control @error('assunto') is-invalid @enderror" 
                                   id="assunto" name="assunto" value="{{ old('assunto') }}" required>
                            @error('assunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="mensagem" class="form-label fw-bold">Mensagem *</label>
                            <textarea class="form-control @error('mensagem') is-invalid @enderror" 
                                      id="mensagem" name="mensagem" rows="6" required>{{ old('mensagem') }}</textarea>
                            @error('mensagem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-cgti btn-lg">
                                <i class="bi bi-send me-2"></i>Enviar Mensagem
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa e Informações Adicionais -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-primary fw-bold mb-4 text-center">Como Chegar</h3>
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="bg-light rounded-3 p-4 h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <i class="bi bi-map text-primary" style="font-size: 4rem;"></i>
                                    <h5 class="mt-3 mb-2">Localização</h5>
                                    <p class="text-muted mb-0">
                                        O IFPE Campus Garanhuns está localizado na BR 232, 
                                        facilmente acessível por transporte público e particular.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="fw-bold mb-3">Pontos de Referência</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    Próximo ao Distrito Industrial de Garanhuns
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-bus-front text-primary me-2"></i>
                                    Acesso por transporte público urbano
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-car-front text-primary me-2"></i>
                                    Estacionamento disponível no campus
                                </li>
                                <li class="mb-0">
                                    <i class="bi bi-signpost text-primary me-2"></i>
                                    Sinalização clara na BR 232
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Rápido -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center fw-bold text-primary mb-4">Perguntas Frequentes</h3>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-primary mb-2">Como solicitar suporte técnico?</h6>
                            <p class="mb-0 text-muted">
                                Entre em contato conosco por telefone, email ou através do formulário acima. 
                                Nossa equipe responderá o mais breve possível.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-primary mb-2">Qual o horário de atendimento?</h6>
                            <p class="mb-0 text-muted">
                                Atendemos de segunda a sexta-feira, das 07:00 às 17:00. 
                                Para emergências, temos plantão disponível.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Validação do formulário
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
    
    function validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        
        if (isRequired && !value) {
            field.classList.add('is-invalid');
            return false;
        }
        
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                field.classList.add('is-invalid');
                return false;
            }
        }
        
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        return true;
    }
});
</script>
@endpush
@endsection


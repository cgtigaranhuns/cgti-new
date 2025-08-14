@extends('layouts.app')

@section('title', 'Apresentação - CGTI IFPE Garanhuns')
@section('description', 'Conheça a Coordenação de Gestão de Tecnologia da Informação do IFPE Campus Garanhuns, nossa
missão, visão e objetivos.')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
            <li class="breadcrumb-item active" aria-current="page">Apresentação</li>
        </ol>
    </nav>

    <!-- Header da Página -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">Apresentação</h1>
            <p class="lead text-muted">Conheça a CGTI e nosso compromisso com a excelência tecnológica</p>
        </div>
    </div>

    <!-- Missão, Visão e Valores -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="text-primary mb-3">
                        <i class="bi bi-bullseye" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title text-primary fw-bold">Missão</h4>
                    <p class="card-text">
                        Prover soluções tecnológicas inovadoras e seguras, garantindo a excelência
                        dos serviços de TI para a comunidade acadêmica do IFPE Campus Garanhuns.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="text-primary mb-3">
                        <i class="bi bi-eye" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title text-primary fw-bold">Visão</h4>
                    <p class="card-text">
                        Ser referência em gestão de tecnologia da informação no âmbito educacional,
                        promovendo a transformação digital e a inovação tecnológica.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="text-primary mb-3">
                        <i class="bi bi-heart" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="card-title text-primary fw-bold">Valores</h4>
                    <p class="card-text">
                        Transparência, inovação, qualidade, colaboração e compromisso com o
                        desenvolvimento tecnológico sustentável e inclusivo.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sobre a CGTI -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h2 class="text-primary fw-bold mb-4">Sobre a CGTI</h2>
                    <p class="mb-4">
                        A Coordenação de Gestão de Tecnologia da Informação (CGTI) do IFPE Campus Garanhuns
                        é responsável por planejar, coordenar e executar as políticas de tecnologia da informação
                        da instituição, garantindo a disponibilidade, segurança e qualidade dos serviços tecnológicos.
                    </p>
                    <p class="mb-4">
                        Nossa equipe trabalha continuamente para oferecer soluções inovadoras que atendam às
                        necessidades da comunidade acadêmica, incluindo estudantes, professores, técnicos
                        administrativos e gestores.
                    </p>
                    <p class="mb-0">
                        Através de uma abordagem colaborativa e focada na excelência, a CGTI contribui para
                        o desenvolvimento institucional e para a formação de profissionais qualificados na
                        área de tecnologia da informação.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Áreas de Atuação -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center fw-bold text-primary mb-5">Áreas de Atuação</h2>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 80px; height: 80px;">
                    <i class="bi bi-shield-check" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Segurança da Informação</h5>
                <p class="text-muted">Proteção de dados e sistemas contra ameaças digitais</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 80px; height: 80px;">
                    <i class="bi bi-building-gear" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Infraestrutura de Rede</h5>
                <p class="text-muted">Gestão e manutenção da infraestrutura de rede do campus</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 80px; height: 80px;">
                    <i class="bi bi-code-square" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Desenvolvimento de Sistemas</h5>
                <p class="text-muted">Criação e manutenção de sistemas institucionais</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 80px; height: 80px;">
                    <i class="bi bi-headset" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Suporte Técnico</h5>
                <p class="text-muted">Atendimento e suporte aos usuários da instituição</p>
            </div>
        </div>
    </div>

    <!-- Objetivos -->
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="bg-light rounded-4 p-5">
                <h2 class="text-center fw-bold text-primary mb-4">Nossos Objetivos</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="text-primary me-3">
                                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Modernização Tecnológica</h6>
                                <p class="mb-0 text-muted">Implementar soluções tecnológicas modernas e eficientes</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="text-primary me-3">
                                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Capacitação Contínua</h6>
                                <p class="mb-0 text-muted">Promover o desenvolvimento da equipe e usuários</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="text-primary me-3">
                                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Qualidade dos Serviços</h6>
                                <p class="mb-0 text-muted">Garantir excelência na prestação de serviços de TI</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="text-primary me-3">
                                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Sustentabilidade</h6>
                                <p class="mb-0 text-muted">Adotar práticas sustentáveis em tecnologia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
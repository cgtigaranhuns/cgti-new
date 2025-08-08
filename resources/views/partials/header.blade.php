<!-- Header Principal -->
<header class="header-cgti">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/cgti-logo.png') }}" alt="CGTI Logo" class="logo">
                </a>
            </div>
            <div class="col-md-8 text-center text-md-start">
                <h4 class="mb-1">Coordenação de Gestão de</h4>
                <h2 class="mb-1">Tecnologia da Informação</h2>
                <h3 class="mb-0">IFPE - CAMPUS GARANHUNS</h3>
            </div>
            <div class="col-md-2 text-center text-md-end">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Painel Admin
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>Sair
                            </a></li>
                        </ul>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <i class="bi bi-lock me-2"></i>Área Restrita
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>


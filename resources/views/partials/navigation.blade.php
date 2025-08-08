<!-- Navegação Principal -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-cgti sticky-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i>Início
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('apresentacao') ? 'active' : '' }}" href="{{ route('apresentacao') }}">
                        <i class="bi bi-info-circle me-1"></i>Apresentação
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-folder me-1"></i>Documentos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('documentos.index', ['categoria' => 'guias']) }}">
                            <i class="bi bi-book me-2"></i>Guias e Manuais
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('documentos.index', ['categoria' => 'normas']) }}">
                            <i class="bi bi-file-text me-2"></i>Normas e Procedimentos
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('documentos.index', ['categoria' => 'legislacao']) }}">
                            <i class="bi bi-file-earmark-text me-2"></i>Legislação
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('documentos.index') }}">
                            <i class="bi bi-files me-2"></i>Todos os Documentos
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('informes.*') ? 'active' : '' }}" href="{{ route('informes.index') }}">
                        <i class="bi bi-newspaper me-1"></i>Informes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('equipe.*') ? 'active' : '' }}" href="{{ route('equipe.index') }}">
                        <i class="bi bi-people me-1"></i>Equipe
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contato') ? 'active' : '' }}" href="{{ route('contato') }}">
                        <i class="bi bi-envelope me-1"></i>Contato
                    </a>
                </li>
            </ul>
            
            <!-- Busca -->
            <form class="d-flex" role="search">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Buscar..." aria-label="Buscar">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>


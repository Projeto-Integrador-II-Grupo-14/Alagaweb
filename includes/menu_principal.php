<nav class="navbar navbar-expand-lg glass-card sticky-top m-2 m-md-3">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
            <i class="bi bi-cloud-rain-heavy-fill text-primary fs-4"></i> AlagaWeb
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="#">Mapa</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Alertas</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Estatísticas</a></li>
            </ul>
            
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center" id="themeToggle" onclick="toggleTheme()" style="width: 40px; height: 40px;">
                    <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                </button>
                
                <button class="btn btn-outline-primary rounded-pill px-4" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                </button>
                <button class="btn btn-primary rounded-pill px-3" type="button" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <i class="bi bi-person-plus me-1"></i> Cadastrar
                </button>
            </div>
        </div>
    </div>
</nav>
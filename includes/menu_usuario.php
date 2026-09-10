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
            
            <div class="d-flex align-items-center gap-3">
                <!-- Botão de Tema (Sol / Lua) -->
                <button class="btn btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center" id="themeToggle" onclick="toggleTheme()" style="width: 40px; height: 40px;" title="Alternar Modo">
                    <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                </button>
                
                <!-- Área do Usuário Logado (Dropdown) -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary rounded-pill px-3 py-1 d-flex align-items-center gap-2 dropdown-toggle border-opacity-50" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5 text-primary"></i>
                        <span class="fw-semibold small"><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></span>
                    </button>
                    
                    <!-- Menu suspenso de perfil -->
                    <ul class="dropdown-menu dropdown-menu-end glass-card border-0 shadow-lg mt-2" aria-labelledby="userMenu">
                        <li class="px-3 py-2 border-bottom border-secondary border-opacity-25">
                            <span class="d-block fw-bold small"><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></span>
                            <small class="text-muted d-block opacity-75" style="font-size: 0.75rem;"><?= htmlspecialchars($_SESSION['usuario']['email']) ?></small>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 mt-1 rounded-2" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="bi bi-person"></i> Meu Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 rounded-2" href="#" data-bs-toggle="modal" data-bs-target="#myOccurrencesModal">
                                <i class="bi bi-journal-text"></i> Minhas Ocorrências
                            </a>
                        </li>
                        <li><hr class="dropdown-divider opacity-25 my-1"></li>
                        <li>
                            <button class="dropdown-item text-danger d-flex align-items-center gap-2 rounded-2 fw-semibold" type="button" onclick="window.location.href='logout.php'">
                                <i class="bi bi-box-arrow-right"></i> Sair
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</nav>



<!-- Modal 1: Meu Perfil -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-card border-0 shadow-lg">
            
            <div class="modal-header border-bottom border-secondary border-opacity-25">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="profileModalLabel">
                    <i class="bi bi-person-bounding-box text-primary fs-4"></i> Meu Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <form id="profileForm" onsubmit="event.preventDefault(); alert('Perfil atualizado com sucesso!');">
                    
                    <!-- Avatar / Header -->
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle display-1 text-primary"></i>
                        <h6 class="fw-bold mt-2 mb-0"><?php echo $_SESSION['usuario']['nome']; ?></h6>
                        <small class="opacity-75">Membro desde <?php echo date('F de Y', strtotime($_SESSION['usuario']['data_cadastro'])); ?></small>
                    </div>

                    <!-- Nome Completo -->
                    <div class="mb-3">
                        <label for="profName" class="form-label small font-monospace">Nome Completo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent custom-input"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control bg-transparent custom-input" id="profName" value="<?php echo $_SESSION['usuario']['nome']; ?>" required>
                        </div>
                    </div>

                    <!-- E-mail -->
                    <div class="mb-3">
                        <label for="profEmail" class="form-label small font-monospace">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent custom-input"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control bg-transparent custom-input" id="profEmail" value="<?php echo $_SESSION['usuario']['email']; ?>" required>
                        </div>
                    </div>

                    <!-- Telefone / WhatsApp -->
                    <div class="mb-3">
                        <label for="profPhone" class="form-label small font-monospace">Telefone / WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent custom-input"><i class="bi bi-whatsapp"></i></span>
                            <input type="tel" class="form-control bg-transparent custom-input" id="profPhone" value="<?php echo $_SESSION['usuario']['telefone']; ?>">
                        </div>
                    </div>

                    <!-- Nova Senha (Opcional) -->
                    <div class="mb-4">
                        <label for="profPassword" class="form-label small font-monospace">Alterar Senha (Opcional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent custom-input"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control bg-transparent custom-input" id="profPassword" placeholder="Deixe em branco para não alterar">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">
                        Salvar Alterações
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Modal 2: Minhas Ocorrências -->
<div class="modal fade" id="myOccurrencesModal" tabindex="-1" aria-labelledby="myOccurrencesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-card border-0 shadow-lg">
            
            <div class="modal-header border-bottom border-secondary border-opacity-25">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="myOccurrencesModalLabel">
                    <i class="bi bi-journal-text text-primary fs-4"></i> Minhas Ocorrências Registradas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr class="opacity-75">
                                <th scope="col">ID</th>
                                <th scope="col">Região / Bairro</th>
                                <th scope="col">Nível Água</th>
                                <th scope="col">Data / Hora</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Exemplo 1 -->
                            <tr>
                                <td class="fw-bold">#1024</td>
                                <td>Rua XPTO (Centro)</td>
                                <td><span class="badge bg-danger bg-opacity-20 text-danger border border-danger">🔴 Alto</span></td>
                                <td><small class="opacity-75">08/09/2026 14:30</small></td>
                                <td><span class="badge bg-warning text-dark">Em Análise</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Ocorrência cancelada/excluída.')" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Exemplo 2 -->
                            <tr>
                                <td class="fw-bold">#0981</td>
                                <td>Av. Brasil (Zona Sul)</td>
                                <td><span class="badge bg-warning bg-opacity-20 text-warning border border-warning">🟠 Médio</span></td>
                                <td><small class="opacity-75">01/09/2026 09:15</small></td>
                                <td><span class="badge bg-success">Resolvido</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-danger" onclick="alert('Ocorrência cancelada/excluída.')" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer border-top border-secondary border-opacity-25 justify-content-between">
                <small class="opacity-75">Total de 2 ocorrências enviadas por você.</small>
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>
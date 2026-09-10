 <!-- Modal de Login -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content glass-card border-0 shadow-lg">
                    
                    <div class="modal-header border-bottom border-secondary border-opacity-25">
                        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="loginModalLabel">
                            <i class="bi bi-person-circle text-primary fs-4"></i> Acesse sua conta
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <form id="loginForm" action="controllers/LoginController.php" method="POST">
                                
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label small font-monospace">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent custom-input">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control bg-transparent custom-input" id="loginEmail" name="email" placeholder="seu@email.com" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="loginPassword" class="form-label small font-monospace">Senha</label>
                                    <a href="#" class="text-primary text-decoration-none small">Esqueceu a senha?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent custom-input">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control bg-transparent custom-input" id="loginPassword" name="senha" placeholder="••••••••" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">
                                Login
                            </button>
                        </form>

                        <hr class="my-4 border-secondary border-opacity-25">

                        <p class="text-center small mb-0 opacity-75">
                                Ainda não tem uma conta? 
                                <a href="#" class="text-primary fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#registerModal">Cadastre-se</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

  <!-- Modal de Cadastro -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content glass-card border-0 shadow-lg">
                    <div class="modal-header border-bottom border-secondary border-opacity-25">
                        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="registerModalLabel">
                            <i class="bi bi-person-plus-fill text-primary fs-4"></i> Criar Nova Conta
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="registerForm" action="controllers/UsuarioController.php" method="POST">
                            
                            <!-- Nome Completo -->
                            <div class="mb-3">
                                <label for="regName" class="form-label small font-monospace">Nome Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent custom-input">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" class="form-control bg-transparent custom-input" id="regName" name="nome" placeholder="Seu nome" required>
                                </div>
                            </div>

                            <!-- E-mail -->
                            <div class="mb-3">
                                <label for="regEmail" class="form-label small font-monospace">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent custom-input">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control bg-transparent custom-input" id="regEmail" name="email" placeholder="seu@email.com" required>
                                </div>
                            </div>

                            <!-- Telefone / WhatsApp -->
                            <div class="mb-3">
                                <label for="regPhone" class="form-label small font-monospace">Telefone / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent custom-input">
                                        <i class="bi bi-whatsapp"></i>
                                    </span>
                                    <input type="tel" class="form-control bg-transparent custom-input" id="regPhone" name="telefone" placeholder="(11) 99999-9999">
                                </div>
                            </div>

                            <!-- Senha -->
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label for="regPassword" class="form-label small font-monospace">Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent custom-input">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>
                                        <input type="password" class="form-control bg-transparent custom-input" id="regPassword" name="senha" placeholder="••••••••" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="regConfirmPassword" class="form-label small font-monospace">Confirmar Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent custom-input">
                                            <i class="bi bi-check2-circle"></i>
                                        </span>
                                        <input type="password" class="form-control bg-transparent custom-input" id="regConfirmPassword" name="confirmarSenha" placeholder="••••••••" required>
                                    </div>
                                </div>
                            </div>

                        
                            <!-- Botão de Ação -->
                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">
                                Finalizar Cadastro
                            </button>
                        </form>

                        <hr class="my-4 border-secondary border-opacity-25">

                        <!-- Link para Login -->
                        <p class="text-center small mb-0 opacity-75">
                            Já possui uma conta? 
                            <a href="#" class="text-primary fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">Faça Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

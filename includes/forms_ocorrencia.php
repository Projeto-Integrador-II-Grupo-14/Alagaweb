 <button class="btn btn-primary btn-floating d-flex align-items-center gap-2 shadow-lg" type="button"
            type="button" 
            data-bs-toggle="modal" 
            data-bs-target="#occurrenceModal" 
            onclick="prepareOccurrenceForm()">
            <i class="bi bi-plus-circle-fill fs-5"></i> Registrar Ocorrência
        </button>



<div class="modal fade" id="occurrenceModal" tabindex="-1" aria-labelledby="occurrenceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content glass-card border-0 shadow-lg">
                    
                    <div class="modal-header border-bottom border-secondary border-opacity-25">
                        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="occurrenceModalLabel">
                            <i class="bi bi-exclamation-triangle-fill text-warning fs-4"></i> Registrar Nova Ocorrência
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <form id="occurrenceForm" onsubmit="handleOccurrenceSubmit(event)">
                            
                            <input type="hidden" id="id_usuario" value="1">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="id_regiao" class="form-label small font-monospace">Região / Bairro</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent custom-input">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                        <select class="form-select bg-transparent custom-input" id="id_regiao" required>
                                            <option value="" selected disabled>Selecione a região...</option>
                                            <option value="1">Centro</option>
                                            <option value="2">Zona Sul</option>
                                            <option value="3">Zona Norte</option>
                                            <option value="4">Zona Leste</option>
                                            <option value="5">Zona Oeste</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="nivel_agua" class="form-label small font-monospace">Nível da Água</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent custom-input">
                                            <i class="bi bi-water"></i>
                                        </span>
                                        <select class="form-select bg-transparent custom-input" id="nivel_agua" required>
                                            <option value="" selected disabled>Selecione a gravidade...</option>
                                            <option value="baixo">🟢 Baixo (Pistas molhadas / Calçada livre)</option>
                                            <option value="medio">🟠 Médio (Água na altura do pneu)</option>
                                            <option value="alto">🔴 Alto (Via intransitável / Risco alto)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="latitude" class="form-label small font-monospace">Latitude</label>
                                    <input type="text" class="form-control bg-transparent custom-input" id="latitude" placeholder="-23.550520" required readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude" class="form-label small font-monospace">Longitude</label>
                                    <input type="text" class="form-control bg-transparent custom-input" id="longitude" placeholder="-46.633309" required readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="data_hora" class="form-label small font-monospace">Data e Hora</label>
                                    <input type="datetime-local" class="form-control bg-transparent custom-input" id="data_hora" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label small font-monospace">Status Inicial</label>
                                    <input type="text" class="form-control bg-transparent custom-input" id="status" value="Em Análise" readonly>
                                </div>

                                <div class="col-12">
                                    <label for="descricao" class="form-label small font-monospace">Descrição Detalhada</label>
                                    <textarea class="form-control bg-transparent custom-input" id="descricao" rows="3" placeholder="Informe pontos de referência, trânsito no local ou detalhes do alagamento..." required></textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning w-100 py-2 rounded-3 fw-bold text-dark d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-send-fill"></i> Enviar Relatório de Ocorrência
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
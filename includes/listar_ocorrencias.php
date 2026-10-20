<?php
require_once "config/database.php";
require_once "models/Ocorrencia.php";

$ultimasOcorrencias = [];


    $ocorrenciaModel2 = new Ocorrencia($pdo);

    $ultimasOcorrencias = $ocorrenciaModel2->listarUltimasOcorrencias();

?>


<div class="row mb-4" id="alertas">
    <div class="col-12">
        <div class="glass-card p-4">

            <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-primary"></i>
                Últimas Ocorrências
            </h5>

            <div class="list-group list-group-flush bg-transparent">

                <?php if (!empty($ultimasOcorrencias)): ?>

                    <?php foreach ($ultimasOcorrencias as $index => $ocorrencia): ?>

                        <?php
                            $risco = strtoupper(trim(
                                $ocorrencia['nivel_agua'] ?? ''
                            ));

                            if (str_contains($risco, 'ALTO')) {
                                $cor = 'text-danger';
                            } elseif (str_contains($risco, 'MEDIO')) {
                                $cor = 'text-warning';
                            } elseif (str_contains($risco, 'BAIXO')) {
                                $cor = 'text-success';
                            } else {
                                $cor = 'text-primary';
                            }

                            $dataRegistro = !empty($ocorrencia['data_hora'])
                                ? strtotime($ocorrencia['data_hora'])
                                : false;

                            if ($dataRegistro === false) {
                                $tempo = 'Data indisponível';
                            } else {
                                $diferenca = max(
                                    0,
                                    time() - $dataRegistro
                                );

                                if ($diferenca < 60) {
                                    $tempo = 'Agora mesmo';
                                } elseif ($diferenca < 3600) {
                                    $minutos = floor($diferenca / 60);
                                    $tempo = 'Há ' . $minutos . ' min';
                                } elseif ($diferenca < 86400) {
                                    $horas = floor($diferenca / 3600);
                                    $tempo = 'Há ' . $horas .
                                        ($horas === 1 ? ' hora' : ' horas');
                                } else {
                                    $dias = floor($diferenca / 86400);
                                    $tempo = 'Há ' . $dias .
                                        ($dias === 1 ? ' dia' : ' dias');
                                }
                            }

                            $descricao = $ocorrencia['descricao']
                                ?? 'Ocorrência sem descrição';
                        ?>

                        <div class="list-group-item bg-transparent
                                    d-flex justify-content-between
                                    align-items-center border-bottom px-0">

                            <span class="me-3">
                                <i class="bi bi-circle-fill <?= $cor ?> me-2"></i>
                                <?= htmlspecialchars(
                                    $descricao,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>

                            <small class="opacity-75 text-nowrap">
                                <?= htmlspecialchars(
                                    $tempo,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </small>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="list-group-item bg-transparent border-0 px-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Nenhuma ocorrência registrada até o momento.
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

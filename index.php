<?php
session_start();

$title = "Gerar Declaração de conteúdo";

include_once("layouts/header.php");

$dadosOption = array(
    "remetente" => array(
        "title" => "remetente",
    ),
    "destinatario" => array(
        "title" => "destinatário",
    )
);

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf_token'];

?>

<h1 id="main-title" class="mt-2">Gerador de Declaração de Conteúdo</h1>

<div class="card mx-auto col-md-8">
    <div class="card-body">
        <div class="alert alert-primary d-flex align-items-center">
            <i class="bi bi-info-square-fill me-2"></i>
            <div>Preencha todos os campos com <span class="text-danger">*</span></div>
        </div>
        <form action="gerar-declaracao.php" method="post" target="_blank" class="row d-flex justify-content-center needs-validation" novalidate autocomplete="off">
            <div class="col-md-12">
                <?php foreach ($dadosOption as $key => $value) : ?>
                    <div class="row">
                        <h3 class="form-section-title">Dados do <?= $value["title"] ?></h3>
                        <div class="col-md-8 mb-2">
                            <label for="nome_<?= $key ?>" class="form-label">Nome*</label>
                            <input type="text" class="form-control form-control-sm" name="nome_<?= $key ?>" required maxlength="50">
                            <div class="invalid-feedback">Informe o nome do <?= $key ?>.</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="documento_<?= $key ?>" class="form-label">CPF/CNPJ*</label>
                            <input type="text" class="form-control form-control-sm documento" name="documento_<?= $key ?>" data-tipo="<?= $key ?>" required>
                            <div class="invalid-feedback">Informe o CPF ou CNPJ do <?= $key ?>.</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="cep_<?= $key ?>" class="form-label">CEP*</label>
                            <input type="text" class="form-control form-control-sm cep" name="cep_<?= $key ?>" data-tipo="<?= $key ?>" required>
                            <div class="invalid-feedback">Informe o CEP do <?= $key ?>.</div>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label for="cidade_<?= $key ?>" class="form-label">Cidade*</label>
                            <input type="text" class="form-control form-control-sm" name="cidade_<?= $key ?>" required maxlength="50">
                            <div class="invalid-feedback">Informe a cidade do <?= $key ?>.</div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="uf_<?= $key ?>" class="form-label">Estado*</label>
                            <select name="uf_<?= $key ?>" class="form-select form-select-sm estados" required maxlength="2">
                                <option value="">--</option>
                            </select>
                            <div class="invalid-feedback">Informe o estado do <?= $key ?>.</div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="endereco_<?= $key ?>" class="form-label">Endereço*</label>
                            <input type="text" class="form-control form-control-sm" name="endereco_<?= $key ?>" minlength="9" maxlength="50" required>
                            <div class="invalid-feedback">Informe o endereço do <?= $key ?>.</div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <h3 class="form-section-title">Detalhes do Envio</h3>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="dt_envio" class="form-label">Data do envio*</label>
                        <input type="text" class="form-control form-control-sm datepicker date" name="dt_envio" required>
                        <div class="invalid-feedback">Informe a data do envio</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label for="cod_rastreamento" class="form-label">Código de Rastreamento</label>
                        <input type="text" class="form-control form-control-sm" name="cod_rastreamento" maxlength="50">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="chk_aut_vizinho" id="chk_aut_vizinho" value="1">
                            <label class="form-check-label" for="chk_aut_vizinho">Autorizar Entrega no Vizinho</label>
                        </div>
                        <input type="text" class="form-control form-control-sm mt-2" name="nome_vizinho" id="nome_vizinho" placeholder="Nome do vizinho" disabled maxlength="50">
                    </div>
                </div>
                <div class="row">
                    <h3 class="form-section-title">Identificação dos bens</h3>
                    <div class="conteudo-container">
                        <div class="row conteudo" data-index="1">
                            <div class="col-md-7 mb-2">
                                <label for="conteudo_1" class="form-label">Conteúdo*</label>
                                <input type="text" class="form-control form-control-sm" name="conteudo[1][name]" id="conteudo_1" maxlength="160" required>
                                <div class="invalid-feedback">Informe o conteúdo da declaração.</div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="quantidade_1" class="form-label">Quant.*</label>
                                <input type="text" class="form-control form-control-sm quantidade" name="conteudo[1][quantidade]" id="quantidade_1" required>
                                <div class="invalid-feedback">Informe a quantidade do conteúdo.</div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="valor_1" class="form-label">Valor*</label>
                                <input type="number" class="form-control form-control-sm" name="conteudo[1][valor]" id="valor_1" min="0.00" step="0.01" required maxlength="10">
                                <div class="invalid-feedback">Informe o valor do conteúdo.</div>
                            </div>
                            <div class="col-md-1 mb-2 d-flex align-items-center">
                                <a href="#" class="link-success adicionar-conteudo">
                                    <i class="bi bi-plus-square-fill" style="font-size: 2rem;"></i>
                                </a>
                            </div>
                        </div>
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-success" id="gerar-declaracao">Gerar declaração</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<p class="text-muted text-center">
    <a href="https://github.com/LucasHayashi" class="link-secondary text-decoration-none p-3" target="_blank"><?= date('Y') ?> - Lucas Hayashi</a>
</p>

<?php include_once("layouts/footer.php") ?>
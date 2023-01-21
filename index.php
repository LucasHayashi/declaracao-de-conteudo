<?php
$title = "Declaração de conteúdo";
include_once("layouts/header.php");

$dadosOption = array(
    "remetente" => array(
        "title" => "remetente",
    ),
    "destinatario" => array(
        "title" => "destinatário",
    )
);
?>

<h1 id="main-title" class="mt-2">Declaração de conteúdo</h1>

<div class="card mx-auto">
    <div class="card-body">
        <form action="gerar-declaracao.php" method="post" target="_blank" class="row d-flex justify-content-center needs-validation" novalidate autocomplete="off">
            <div class="col-md-12">
                <?php foreach ($dadosOption as $key => $value) : ?>
                    <div class="row">
                        <h3 class="form-section-title">Dados do <?= $value["title"] ?></h3>
                        <div class="col-md-8">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="nome_<?= $key ?>" placeholder="Lucas Felipe" required>
                                <label for="nome_<?= $key ?>" class="form-label">Nome</label>
                                <div class="invalid-feedback">Informe o nome do <?= $key ?>.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control documento" name="documento_<?= $key ?>" data-tipo="<?= $key ?>" placeholder="454.999.888-78" required>
                                <label for="documento_<?= $key ?>" class="form-label">CPF/CNPJ</label>
                                <div class="invalid-feedback">Informe o CPF ou CNPJ do <?= $key ?>.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control cep" name="cep_<?= $key ?>" data-tipo="<?= $key ?>" placeholder="17032-500" required>
                                <label for="cep_<?= $key ?>" class="form-label">CEP</label>
                                <div class="invalid-feedback">Informe o CEP do <?= $key ?>.</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cidade_<?= $key ?>" placeholder="Bauru" required>
                                <label for="cidade_<?= $key ?>" class="form-label">Cidade</label>
                                <div class="invalid-feedback">Informe a cidade do <?= $key ?>.</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <select name="uf_<?= $key ?>" name="uf_<?= $key ?>" class="form-select estados" required>
                                    <option value="">--</option>
                                </select>
                                <label for="uf_<?= $key ?>" class="form-label">Estado</label>
                                <div class="invalid-feedback">Informe o estado do <?= $key ?>.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="endereco_<?= $key ?>" minlength="9" required placeholder="Rua. Teste 123">
                                <label for="endereco_<?= $key ?>" class="form-label">Endereço</label>
                                <div class="invalid-feedback">Informe o endereço do <?= $key ?>.</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <h3 class="form-section-title">Data do envio</h3>
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control datepicker" name="dt_envio" required placeholder="18/01/2023">
                            <label for="dt_envio" class="form-label">Data</label>
                            <div class="invalid-feedback">Informe a data do envio</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3 class="form-section-title">Identificação dos bens</h3>
                    <div class="conteudo-container">
                        <div class="conteudo row" data-index="1">
                            <div class="col-md-7">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="conteudo[1][name]" id="conteudo_1" placeholder="Apple iPhone 14 Pro Max (256 GB)" required>
                                    <label for="conteudo_1">Conteúdo</label>
                                    <div class="invalid-feedback">Informe o conteúdo da declaração.</div>
                                </div>
                            </div>
                            <div class="col-5 col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control quantidade" name="conteudo[1][quantidade]" id="quantidade_1" placeholder="8" required>
                                    <label for="quantidade_1">Quantidade</label>
                                    <div class="invalid-feedback">Informe a quantidade do conteúdo.</div>
                                </div>
                            </div>
                            <div class="col-5 col-md-2">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="conteudo[1][valor]" id="valor_1" placeholder="10800,00" step="0.01" required>
                                    <label for="valor_1">Valor</label>
                                    <div class="invalid-feedback">Informe o valor do conteúdo.</div>
                                </div>
                            </div>
                            <div class="col-2 col-md-1">
                                <a href="#" class="link-success adicionar-conteudo">
                                    <i class="bi bi-plus-square-fill" style="font-size: 2rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-success" id="gerar-declaracao">Gerar declaração
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<p class="text-muted text-center">
        <a href="https://github.com/LucasHayashi" class="link-secondary text-decoration-none p-3" target="_blank">By Lucas Hayashi</a>
    </p>

<?php include_once("layouts/footer.php") ?>
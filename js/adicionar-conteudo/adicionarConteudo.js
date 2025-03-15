export const adicionarConteudo = function (e) {
  e.preventDefault();

  const conteudoContainer = $(".conteudo-container");
  const ultimoConteudo = $(".conteudo").last();
  const index = ultimoConteudo.data("index") + 1;

  let html = `<div class="row conteudo" data-index="${index}">
                <div class="col-md-7 mb-2">
                    <label for="conteudo_${index}" class="form-label">Conteúdo*</label>
                    <input type="text" class="form-control form-control-sm" name="conteudo[${index}][name]" id="conteudo_${index}" maxlength="160" required>
                    <div class="invalid-feedback">Informe o conteúdo da declaração.</div>
                </div>
                <div class="col-md-2 mb-2">
                    <label for="quantidade_${index}" class="form-label">Quant.*</label>
                    <input type="text" class="form-control form-control-sm quantidade" name="conteudo[${index}][quantidade]" id="quantidade_${index}" required>
                    <div class="invalid-feedback">Informe a quantidade do conteúdo.</div>
                </div>
                <div class="col-md-2 mb-2">
                    <label for="valor_${index}" class="form-label">Valor*</label>
                    <input type="number" class="form-control form-control-sm" name="conteudo[${index}][valor]" id="valor_${index}" min="0.00" step="0.01" required>
                    <div class="invalid-feedback">Informe o valor do conteúdo.</div>
                </div>
                <div class="col-md-1 mb-2 d-flex align-items-center">
                    <a href="#" class="link-danger remover-conteudo">
                        <i class="bi bi-x-square-fill" style="font-size: 2rem;"></i>
                    </a>
                </div>
            </div>`;

  conteudoContainer.append(html);

  $("[data-index=" + index + "]")
    .get(0)
    .scrollIntoView(); // Navega até o elemento criado
};

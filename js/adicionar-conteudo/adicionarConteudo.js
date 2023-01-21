export const adicionarConteudo = function (e) {
    e.preventDefault();

    let conteudoContainer = $(".conteudo-container");
    let ultimoConteudo = $(".conteudo").last();
    let ultimoBtnAdd = ultimoConteudo.find(".adicionar-conteudo");
    let ultimoBtnAddIcon = ultimoBtnAdd.find("i");

    let index = ultimoConteudo.data("index") + 1;

    ultimoBtnAdd.removeClass("link-success adicionar-conteudo");
    ultimoBtnAdd.addClass("link-danger remover-conteudo");
    ultimoBtnAddIcon.removeClass("bi-plus-square-fill");
    ultimoBtnAddIcon.addClass("bi-x-square-fill");

    let html = `<div class="conteudo row" data-index="${index}">
                    <div class="col-md-7">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="conteudo[${index}][name]" id="conteudo_${index}"
                                placeholder="Apple iPhone 14 Pro Max (256 GB)" required>
                            <label for="conteudo_${index}">Conteúdo</label>
                            <div class="invalid-feedback">Informe o conteúdo da declaração.</div>
                        </div>
                    </div>
                    <div class="col-5 col-md-2">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control quantidade" name="conteudo[${index}][quantidade]" id="quantidade_${index}"
                                placeholder="8" required>
                            <label for="quantidade_${index}">Quantidade</label>
                            <div class="invalid-feedback">Informe a quantidade do conteúdo.</div>
                        </div>
                    </div>
                    <div class="col-5 col-md-2">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="conteudo[${index}][valor]" id="valor_${index}"
                                placeholder="10800,00" step="0.01" required>
                            <label for="valor_${index}">Valor</label>
                            <div class="invalid-feedback">Informe o valor do conteúdo.</div>
                        </div>
                    </div>
                    <div class="col-2 col-md-1">
                        <a href="#" class="link-success adicionar-conteudo">
                            <i class="bi bi-plus-square-fill" style="font-size: 2rem;"></i>
                        </a>
                    </div>
                </div>`;

    conteudoContainer.append(html);

    $("[data-index="+index+"]").get(0).scrollIntoView(); // Navega até o elemento criado
};
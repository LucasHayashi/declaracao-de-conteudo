export const removerConteudo = function (e) {
    e.preventDefault();
    $(this).closest(".conteudo").remove();
};

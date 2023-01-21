import { adicionarConteudo } from "./adicionar-conteudo/adicionarConteudo.js";
import { carregaEstados } from "./carrega-estados/carregaEstados.js";
import { checarFormulario } from "./checar-campos-invalidos/checarFormulario.js";
import { habilitarMascaras } from "./habilitar-mascaras/habilitarMascaras.js";
import { preencheEndereco } from "./preenche-endereco/preencheEndereco.js";
import { removerConteudo } from "./remover-conteudo/removerConteudo.js";
import { validaDocumento } from "./valida-documento/validaDocumento.js";

$(document).ready(function () {
    habilitarMascaras();
    carregaEstados();
    $(".cep").on("blur", preencheEndereco);
    $(".documento").on("blur", validaDocumento);
    $(".needs-validation").on("submit", checarFormulario);
    $(document).on("click", ".adicionar-conteudo", adicionarConteudo);
    $(document).on("click", ".remover-conteudo", removerConteudo);
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        language: 'pt-BR'
    });
});

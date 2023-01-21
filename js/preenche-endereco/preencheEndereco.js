import { clearInputAndFocus } from "../helpers/clearInputAndFocus.js";
import { validaCEP } from "../helpers/validaCep.js";

export const preencheEndereco = function () {
    const tipoDePessoa = $(this).data("tipo");
    const cep = $(this);

    let cidade = $("[name=cidade_" + tipoDePessoa + "]");
    let uf = $("[name=uf_" + tipoDePessoa + "]");
    let endereco = $("[name=endereco_" + tipoDePessoa + "]");

    if (validaCEP(cep.val())) {
        if (cep.val().length) {
            $.get(`https://viacep.com.br/ws/${cep.val()}/json`, function (data) {
                if (!data.erro) {
                    cidade.val(data.localidade);
                    uf.val(data.uf);
                    endereco.val(data.logradouro);
                } else {
                    alert("CEP não localizado na base de dados");
                    limpaEndereco(tipoDePessoa);
                }
            });
        }
    } else {
        alert("CEP incompleto!");
        clearInputAndFocus(cep);
    }
}

function limpaEndereco(tipoDePessoa) {
    let cidade = $("[name=cidade_" + tipoDePessoa + "]");
    let uf = $("[name=uf_" + tipoDePessoa + "]");
    let endereco = $("[name=endereco_" + tipoDePessoa + "]");
    cidade.val(" ");
    uf.val(" ");
    endereco.val(" ");
}
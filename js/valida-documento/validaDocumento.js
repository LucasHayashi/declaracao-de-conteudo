import { validaCpf } from "../helpers/validaCpf.js";
import { validaCnpj } from "../helpers/validaCnpj.js";
import { clearInputAndFocus } from "../helpers/clearInputAndFocus.js";

export const validaDocumento = function () {
    const docEl = $(this);
    const docVal = docEl.val();
    const docLen = docVal.length;
    const tamanhosPermitidos = [0, 14, 18];

    if (tamanhosPermitidos.includes(docLen)) {
        if (docLen === 14) {
            if (!validaCpf(docVal)) {
                alert("O CPF digitado é inválido!");
                clearInputAndFocus(docEl);
            }
        } else if (docLen === 18) {
            if (!validaCnpj(docVal)) {
                alert("O CNPJ digitado é inválido!");
                clearInputAndFocus(docEl);
            }
        }
    } else {
        alert("Documento incompleto!");
        clearInputAndFocus(docEl);
    }
}
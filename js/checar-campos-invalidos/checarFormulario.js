export const checarFormulario = function (e) {
    e.preventDefault()

    if (!$(this)[0].checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
    }else {
        $(this)[0].submit();
    }
    
    $(this).addClass("was-validated");
}
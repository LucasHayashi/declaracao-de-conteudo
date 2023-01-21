export const habilitarMascaras = function () {
    $(".cep").mask("00000-000");
    $(".date").mask("00/00/0000");

    var options = {
        onKeyPress: function (cpf, e, field, options) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = (cpf.length > 14) ? masks[1] : masks[0];
            $('.documento').mask(mask, options);
        }
    };

    $('.documento').mask('000.000.000-000', options);

    $(document).on("focus", ".quantidade", function () {
        $(this).mask("0000000", { reverse: true });
    });
};
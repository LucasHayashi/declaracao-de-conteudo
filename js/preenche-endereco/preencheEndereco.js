
export const preencheEndereco = function () {
    const tipoDePessoa = $( this ).data( "tipo" );
    const cep = $(this);
    let cidade = $( "[name=cidade_" + tipoDePessoa );
    let uf = $( "[name=uf_" + tipoDePessoa );
    let endereco = $( "[name=endereco_" + tipoDePessoa );
    
    $.get(`https://viacep.com.br/ws/${cep.val()}/json`, function(data){
        if (!data.erro) {
            cidade.val(data.localidade);
            uf.val(data.uf);
            endereco.val(data.logradouro);
        }else {
            $(cep).val("");
            limpaCampos(tipoDePessoa)
        }
    });
}

function limpaCampos(tipoDePessoa) {
    let cidade = $( "#cidade_" + tipoDePessoa );
    let uf = $( "#uf_" + tipoDePessoa );
    let endereco = $( "#endereco_" + tipoDePessoa );

    cidade.val( " " );
    uf.val( " " );
    endereco.val( " " );
}
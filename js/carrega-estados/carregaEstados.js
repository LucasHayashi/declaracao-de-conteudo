export const carregaEstados = () => {
    $.getJSON( "json/estados-brasileiros.json", function(data) {
        const selectEstados = $(".estados");
        $.each( data.UF , function(key, value) {
            selectEstados.append(`
                <option value="${value.sigla}">${value.sigla}</option>
            `);
        })
    } )
}
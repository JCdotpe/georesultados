function cargandoAjax(ref) {
    $(ref).html('<img width="16" src="http://localhost:88/informativo/assets/img/icono/generando.gif" /> ');
}
function validar(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8)
        return true;
    if (tecla == 48)
        return true;
    if (tecla == 49)
        return true;
    if (tecla == 50)
        return true;
    if (tecla == 51)
        return true;
    if (tecla == 52)
        return true;
    if (tecla == 53)
        return true;
    if (tecla == 54)
        return true;
    if (tecla == 55)
        return true;
    if (tecla == 56)
        return true;
    if (tecla == 57)
        return true;
    patron = /1/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function filtrarTablaLista(modulo, envio) {

    url = 'http://localhost/georesultados/' + modulo + '?envio=1';
    $('div.h3_footer input[type=text]').each(function() {
        valor = fixedEncodeURIComponent($(this).val());
        variable = $(this).attr('name');
        url = url + '&' + variable + '=' + valor;
    });

    $('div.coger_valor select').each(function() {
        valor = $(this).val();
        variable = $(this).attr('name');
        url = url + '&' + variable + '=' + valor;
    });
    if (envio == 1) {
        $('.mihref').attr('href', url);
        $('.mihref').click();
    }
}

function fixedEncodeURIComponent(str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, escape);
}
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

$(function() {
    $('#optCodigo').click(function() {
        $("#dv_searchColegio").slideUp('fast').hide();
        $("#dv_search").show();
        $("#searchCodigo").focus();
        
    });
    $('#optColegio').click(function() {
        $("#dv_search").slideUp('fast').hide();
        $('#searchCodigo').val("");
        $('#searchColegio').val("").focus();
        $('#dv_download').attr("href", "").hide();
        $("#dv_searchColegio").show();
        
        
    });
});


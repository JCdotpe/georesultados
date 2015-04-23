function cargandoAjax(ref) {
    $(ref).html('<img width="16" src="' + CI.base_url + 'assets/img/icono/generando.gif" alt="LogoGenerando"/> ');
}
function validar(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla === 8)
        return true;
    if (tecla === 48)
        return true;
    if (tecla === 49)
        return true;
    if (tecla === 50)
        return true;
    if (tecla === 51)
        return true;
    if (tecla === 52)
        return true;
    if (tecla === 53)
        return true;
    if (tecla === 54)
        return true;
    if (tecla === 55)
        return true;
    if (tecla === 56)
        return true;
    if (tecla === 57)
        return true;
    patron = /1/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function filtrarTablaLista(ruta, modulo, envio) {
    url = ruta + modulo + '?envio=1';
    $('div.h3_footer input[type=text]').each(function () {
        valor = fixedEncodeURIComponent($(this).val());
        variable = $(this).attr('name');
        url = url + '&' + variable + '=' + valor;
    });

    $('div.coger_valor select').each(function () {
        valor = $(this).val();
        variable = $(this).attr('name');
        url = url + '&' + variable + '=' + valor;
    });
    if (envio === 1) {
        $('.mihref').attr('href', url);
        setTimeout(function () {
            $('.mihref').click();
        }, 500);
    }
}

function fixedEncodeURIComponent(str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, escape);
}

$(function () {
    $("#dv_searchParent").hide();
    $("#div-colegio").hide();
    $("#download_general_archive").hide();
    $("#boton_accion_codigo").hide();
    $("#boton_accion_colegio").hide();
    $('.mihref').attr('href', '');

    $("#optCodigo").on("click", function () {
        $(".cod_error").empty();
        $(".cod_errorIE").empty();
        $(".mihref").removeAttr('href');
        $("#div-colegio").hide();
        $("#dv_searchParent").show();
        $("#searchCodigo").val("");
        $("#searchColegio").val("");
        $("#boton_accion_colegio").hide();
        $("#boton_accion_codigo").show();
        $("#download_general_archive").show();
        $('#prov').empty();
        $('#dist').empty();
        $("#prov").append('<option value="">Seleccione</option>');
        $("#dist").append('<option value="">Seleccione</option>');
        $("#dv_dep .select2-chosen").text("Seleccione");
        $('#depa').prop('selectedIndex', 0);
        $("#depa").val("");
        $("#dv_prov .select2-chosen").text("Seleccione");
        $("#dv_dist .select2-chosen").text("Seleccione");
        $("#searchCodigo").focus();
        $(".changeButtonFiltro").attr('id', "filtrarCodigo");
    });

    $("#optColegio").on("click", function () {
        $(".cod_error").empty();
        $(".cod_errorIE").empty();
        $(".mihref").removeAttr('href');
        $("#dv_searchParent").hide();
        $("#div-colegio").show();
        $("#searchCodigo").val("");
        $("#searchColegio").val("");
        $("#boton_accion_colegio").show();
        $("#boton_accion_codigo").hide();
        $("#download_general_archive").show();
        $("#searchColegio").focus();
    });

    $("#filtrarCodigo").on("click", function () {
        var codVacio = $("#searchCodigo").val();
        if (codVacio === "") {
            $(".cod_error").html('<span>Ingrese código del local</span>');
            return false;
        } else if (codVacio.length < 6) {
            $(".cod_error").html('<span>Código tiene 6 números</span>');
            return false;
        } else {
            $(".cod_error").html('');
            filtrarTablaLista(CI.base_url, 'buscarDatosLocal', 1);
        }
    });


    $("#filtrarIE").on("click", function () {
        var colVacio = $("#searchColegio").val();
        var departa = $("#depa option:selected").val();
        if (colVacio === "" && departa === "") {
            $(".cod_errorIE").html('<span>Ingrese nombre I.E o eliga Departamento</span>');
            return false;
        } else if (colVacio === "" && departa !== "") {
            $(".cod_errorIE").html('');
            filtrarTablaLista(CI.base_url, 'buscarDatosLocal', 1);
        } else if (colVacio !== "" && departa === "") {
            $(".cod_errorIE").html('');
            filtrarTablaLista(CI.base_url, 'buscarDatosLocal', 1);
        } else {
            $(".cod_errorIE").html('');
            filtrarTablaLista(CI.base_url, 'buscarDatosLocal', 1);
        }
    });


});
$(document).on('click', '#download_filtro_datos', function () {
//    alert("ja ja aaj");
    var url_donwload = $('#download_filtro_datos').attr('href');
    $.ajax({
        url: url_donwload,
        type: 'GET',
        beforeSend: function () {
            $('#download_filtro_datos').addClass("span_a_download");
            $('#download_filtro_datos').html("<i id='change_carga' class='fa fa-spinner fa-pulse '></i> Exportando Resultados");
        },
        success: function (data) {
            if (data) {
                $('#download_filtro_datos').removeClass("span_a_download");
                $('#download_filtro_datos').html("<i id='change_carga' class='fa fa-download'></i> Exportar Resultados");
            }
        }
    });

});

function llevarMapa(local_id) {
    var num_local_id = local_id;
    var url = CI.base_url + "home/getBubble?idCodigo=" + num_local_id;
    $.get(url, function (data) {
        $("#btnDonwload").attr("href", CI.base_url + "exportar/csvexport/por_Codigo?idCodigo=" + num_local_id);
        var result = JSON.parse(data);
        $.each(result, function (i, datos) {
            var latitud = datos.LatitudPunto_UltP;
            var longitud = datos.LongitudPunto_UltP;
            var puntokml = datos.cod_dpto + datos.cod_prov + datos.cod_dist;
            load_kml_ft(table_dist, puntokml);
            zomCenter = new google.maps.LatLng(latitud, longitud);
            zom = 8;
            map.setCenter(zomCenter);
            map.setZoom(zom);
        });
        var query = " id_local = '" + num_local_id + "' ";
        load_fusiontable(query);
    });
}
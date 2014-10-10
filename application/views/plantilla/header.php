<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo (isset($titulo) and $titulo != "") ? $titulo . " | " : ""; ?>INEI</title>
        <!-- Enlace a estilos -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/select2.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/maps.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/info.css">
        <!-- Enlace a Javascript -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript" src="http://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js"></script>
        <style type="text/css">
            ul.tabs {
                margin: 0;
                padding: 0;
                float: left;
                list-style: none;
                height: 32px;
                border-bottom: 1px solid #999;
                border-left: 1px solid #999;
            }
            ul.tabs li {
                float: left;
                margin: 0;
                padding: 0;
                height: 31px;
                line-height: 31px;
                border: 1px solid #999;
                border-left: none;
                margin-bottom: -1px;
                overflow: hidden;
                position: relative;
                background: #e0e0e0;
            }
            ul.tabs li a {
                text-decoration: none;
                color: #000;
                display: block;
                font-size: 1.2em;
                padding: 0 12px;
                border: 1px solid #fff;
                outline: none;
            }
            ul.tabs li a:hover {
                background: #ccc;
            }
            ul.tabs li.active, html ul.tabs li.active a:hover  {
                background: #fff;
                border-bottom: 1px solid #fff;
            }
/*            ul.tabs li:first-child a{
                color: #c7254e;
                font-weight: bold;
            }
            ul.tabs li:nth-child(2) a{
                color: #003399;
                font-weight: bold;
            }*/
            .tab_container {
                border: 1px solid #999;
                border-top: none;
                overflow: hidden;
                clear: both;
                float: left; width: 100%;
                background: #fff;
            }
            .tab_content {
                padding: 10px 0;
                width:550px;
            }
            .tab_content h4{
                font-family: 'Arimo', sans-serif;
                color: #fff;
                text-transform: uppercase;
                background: #1a4f83;
                font-weight: bold;
                border-radius: 5px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                padding: 10px 0;
                margin-top: 0;
                text-align: center;
            }
            .general_content_name{
                font-size: 16px;
            }
            .general_content{
                font-size: 11px;
            }
            .select2-results {
                /*font-family: 'Arimo', sans-serif;*/
                font-size: 12px;
            }
            .foto_img{
                width:500px;
                height: 330px;
                border-radius: 5px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
            }
            .foto_img_croqui{
                width:500px;
                height: 280px;
                border-radius: 5px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
            }

            .foto_img_croqui_toma{
                width:100%;
                height: 135px;
                border-radius: 5px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                margin-bottom: 10px;
                -webkit-transition:-webkit-transform 1s ease-out;
                -moz-transition:-moz-transform 1s ease-out;
                -o-transition:-o-transform 1s ease-out;
                -ms-transition:-ms-transform 1s ease-out;
                transition:transform 1s ease-out;
            }

            .foto_img_croqui_toma:hover{
                -moz-transform: scale(1.1);
                -webkit-transform: scale(1.1);
                -o-transform: scale(1.1);
                -ms-transform: scale(1.1);
                transform: scale(1.1);
                cursor: pointer;
            }

            table.content_infra_table tbody tr td{
                padding-bottom: 0;
            }
            
            .infra_content_name_collapse{
                font-size: 11px;
                text-transform: uppercase;
                color: #000;
            }
            .infra_content_name_collapse a:hover{
                color:#1a4f83;
                text-decoration: none !important;
                font-weight: bold;
            }
            .all_acordion{
                border: 1px solid #adbece;
                border-radius: 0 0 5px 5px;
                -webkit-border-radius: 0 0 5px 5px;
                -moz-border-radius: 0 0 5px 5px;
            }
            .all_acordion_chidren{
                border-radius: 0px !important;
            }
            .all_acordion_title{
                padding: 10px 6px;
            }
            .all_acordion_panelBody{
                padding: 5px;
            }
        </style>
        <!-- script para traer los valores -->
        <script type="text/javascript">
            google.load('visualization', '1', {'packages': ['corechart', 'table', 'geomap']});
            var kmlArray = [];
            var maploaded = false;
            var layer;
            var capaKml;
            var table_data = '1be4h6-mmQ8GdQEwGIjn2CE5vVJnuuRZzAKgMPRfa';
            var table_dpto = '1GpIA0mBHMTame6QFenQeQCazLW4NiLciy3lfLvSZ';
            var table_prov = '1tmpbIqHGt8ymHU_L_qTEOpzcMHTOh3i_zzvWB7ZQ';
            var table_dist = '1Qvu7A-6HA7TCPVTAJ6xgld_3J7UFBr2SIlbQBz4w';
            var infowindow = new google.maps.InfoWindow({
                size: new google.maps.Size(550, 450)
            });
            function checkGoogleMap() {
                var msg = document.getElementById('msg');
                if (maploaded == false) {
                    msg.innerHTML = '<b><center><em><font face="Brush Script Std">Cargando Puntos </font></em><img src="<?php echo base_url()?>assets/img/294.gif" /></center></b>';
                    $("#msg").slideDown("fast");
                } else {
                    msg.innerHTML = '<b><center><font face="Brush Script Std">Puntos Cargados</font><img src="<?php echo base_url()?>assets/img/08.gif" /></center></b>';
                    $("#msg").delay("slow").slideUp('slow');
                }
            }
            function initialize() {
                var myOptions = {
                    zoom: 6,
                    center: new google.maps.LatLng(-10.089204, -69.802552),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoomControl: true,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.LARGE,
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    },
                    streetViewControl: true,
                    streetViewControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    },
                    panControl: false,
                    panControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    },
                    scaleControl: false,
                    scaleControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    },
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    }
                };
                map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
                capaKml = new google.maps.FusionTablesLayer({
                    query: {
                        select: "geometry",
                        from: table_dpto
                    },
                    options: {
                        styleId: 2,
                        templateId: 2
                    }
                });
                capaKml.setMap(map);
            }
            google.maps.event.addDomListener(window, 'load', initialize);

            $(document).ready(function() {
                initialize();
                $.getJSON('<?php echo base_url() ?>assets/json/region.json', function(regionjson) {
                    $.each(regionjson.Departamento, function(i, nombre) {
                        $("#depa").append('<option id="' + i + '" value="' + nombre.CCDD + '" >' + nombre.Nombre + '</option>');
                    });
                });
                $('.select2').select2();
                carga_departamento();

                $("#btnFindCodLocal").click(function() {
                    var codLocal = $('#searchCodigo').val();
                    if (codLocal == "") {
                        alert("Ingrese código");
                    } else {
                        $('#prov').empty();
                        $("#prov").append('<option value="">Seleccione</option>');
                        $("#dv_prov .select2-chosen").text("Seleccione");
                        $("#dv_dist .select2-chosen").text("Seleccione");
                        $('#depa option:selected').val("");
                        $("#dv_dep .select2-chosen").text("Seleccione");
                        carga_departamento();
                        var url = "<?php echo base_url() ?>home/getBubble?idCodigo=" + codLocal;
                        $.get(url, function(data) {
                            if(data.length==2){
                                alert("Código incorrecto");
                                initialize();
                            }else{
                                var result = JSON.parse(data);
                                $.each(result, function(i, datos) {
                                    var latitud = datos.LatitudPunto_UltP;
                                    var longitud = datos.LongitudPunto_UltP;
                                    var puntokml = datos.CCDD+datos.CCPP+datos.CCDI;
                                    console.log(puntokml);
                                    load_kml_ft(table_dist, puntokml);

                                    zomCenter = new google.maps.LatLng(latitud, longitud);
                                    zom = 8;
                                    map.setCenter(zomCenter);
                                    map.setZoom(zom);
                                });
                                var query = " id_local = '" + codLocal + "' ";

                                load_fusiontable(query);
                            }
                        });
                    }
                });

                $('#depa').change(function() {
                    var cod_ubigeo;
                    $('#searchCodigo').val("");
                    $('#prov').empty();
                    $("#prov").append('<option value="">Seleccione</option>');
                    $("#dv_prov .select2-chosen").text("Seleccione");
                    $("#dv_dist .select2-chosen").text("Seleccione");
                    if ($(this).val() != "" && $(this).val() != -1) {
                        load_ubigeo('PROV');
                    }
                    $('#dist').html('<option value="">Seleccione</option>');
                    if ($(this).val() != "" && $(this).val() != -1) {
                        cod_ubigeo = $(this).val();

                        load_kml_ft(table_dpto, cod_ubigeo);
                    } else if ($(this).val() == -1) {
                        carga_departamento();
                    }
                    load_fusiontable();
                });
                $('#prov').change(function() {
                    var cod_ubigeo;
                    $("#dist").empty();
                    $("#dist").append('<option value="">Seleccione</option>');
                    $("#dv_dist .select2-chosen").text("Seleccione");
                    if ($(this).val() != "") {
                        load_ubigeo('DIST');
                    }
                    if ($(this).val() != "") {
                        cod_ubigeo = $('#depa').val() + $(this).val();

                        load_kml_ft(table_prov, cod_ubigeo);
                    } else {
                        load_kml_ft(table_dpto, $('#depa').val());
                    }
                    load_fusiontable();
                });
                $('#dist').change(function() {
                    var cod_ubigeo;
                    if ($(this).val() != "") {
                        cod_ubigeo = $('#depa').val() + $('#prov').val() + $(this).val();

                        load_kml_ft(table_dist, cod_ubigeo);
                    } else {
                        cod_ubigeo = $('#depa').val() + $('#prov').val();

                        load_kml_ft(table_prov, cod_ubigeo);
                    }
                    load_fusiontable();
                });
            });

            function load_fusiontable(query) {
                query = query || "";
                if (layer != undefined) {
                    layer.setMap(null);
                }
                if($('#searchCodigo').val() !="" && $('#depa').val() == ""){
                    maploaded = false;
                    checkGoogleMap();
                    condicion = query;
                    cargar_tabs();

                }
                if ($('#depa').val() != "") {
                    maploaded = false;
                    checkGoogleMap();
                    condicion = ($('#depa').val() != "" && $('#depa').val() != -1) ? " CCDD = '" + $('#depa').val() + "'" : '';
                    condicion += ($('#prov').val() != "") ? " AND CCPP = '" + $('#prov').val() + "'" : '';
                    condicion += ($('#dist').val() != "") ? " AND CCDI = '" + $('#dist').val() + "'" : '';
                    cargar_tabs();
                }
            }

            function cargar_tabs(zoom){
//                zoom = zoom || false;
                var interval = setInterval(function() {
                        clearInterval(interval);
                        layer = new google.maps.FusionTablesLayer({
                            query: {
                                select: " * ",
                                from: table_data,
                                where: condicion
                            },
                            suppressInfoWindows: true,
                            options: {
                                styleId: 2,
                                templateId: 2
                            }
                        });
                        layer.setMap(map);
                        infowindow.close();
                        google.maps.event.addListener(layer, 'click', function(e) {
                            var codigoid = e.row['id_local'].value;
                            var contentString = '<div>';
                            var url = "<?php echo base_url() ?>home/getBubble?idCodigo=" + codigoid;
                            $.get(url, function(data) {
                                var result = JSON.parse(data);
                                $.each(result, function(i, datos) {
                                    $('.micodigolocal').append(datos.id_local);
                                    $('.minombreie').append(datos.P1_A_2_1_NomIE);
                                    $('.milatitud').append(datos.LatitudPunto_UltP);
                                    $('.milongitud').append(datos.LongitudPunto_UltP);
                                    $('.mipropietariolocal').append(datos.Propietario_Local);
                                    $('.midireccion').append(datos.Direccion);
                                    $('.midepartamento').append(datos.Nomb_Dpto);
                                    $('.miprovincia').append(datos.Nomb_Prov);
                                    $('.midistrito').append(datos.Nomb_Dist);
                                    $('.midirector').append(datos.Nombre_Director);
                                    $('.miniveleducativo').append(datos.Nivel);
                                    if(datos.Telefono == null){
                                        $('.mitelefono').append("--");
                                    }else{
                                        $('.mitelefono').append(datos.Telefono);
                                    }
                                });
                            });

                            contentString += '<ul class="tabs">' +
                                    '<li class="active"><a href="#tab1">GENERAL</a></li>' +
                                    '<li><a href="#tab2">INFRAESTRUCTURA</a></li>' +
                                    '<li><a href="#tab3">CROQUIS</a></li>' +
                                    '<li><a href="#tab4">OTRAS TOMAS</a></li>' +
                                    '</ul>' +
                                    '<div class="tab_container">' +
                                        '<div id="tab1" class="tab_content">' +
                                            '<div class="col-xs-12 h3_footer">' +
                                                '<div class="general">' +
                                                    '<div class="general_content">' +
                                                        '<h3 class="general_content_name text-center">Información del local escolar - código: <span class="micodigolocal"></span></h3>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-3"><strong class="">Nombre de la I.E </strong></div>' +
                                                            '<div class="col-xs-3"><span class="minombreie"></span></div>' +
                                                            '<div class="col-xs-3"><strong class="">Nivel Educativo</strong></div>' +
                                                            '<div class="col-xs-3"><span class="miniveleducativo"></span></div>' +
                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-3"><strong class="">Nombre del director </strong></div>' +
                                                            '<div class="col-xs-3"><span class="midirector"></span></div>' +
                                                            '<div class="col-xs-3"><strong class="">Teléfono</strong></span></div>' +
                                                            '<div class="col-xs-3"><span class="mitelefono"></span></div>' +
                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-3"><strong >Dirección </strong></div>' +
                                                            '<div class="col-xs-3"><span class="midireccion"></span></div>' +
                                                            '<div class="col-xs-6">'+
                                                                '<div class="col-xs-6"><strong >Departamento</strong></div>' +
                                                                '<div class="col-xs-6"><span class="midepartamento"></span></div>' +
                                                                '<div class="col-xs-6"><strong >Provincia</strong></div>' +
                                                                '<div class="col-xs-6"><span class="miprovincia"></span></div>' +
                                                                '<div class="col-xs-6"><strong >Distrito</strong></div>' +
                                                                '<div class="col-xs-6"><span class="midistrito"></span></div>' +
                                                            '</div>'+

                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-3"><strong class="">Propietario local </strong></div>' +
                                                            '<div class="col-xs-9"><span class="mipropietariolocal"></span></div>' +
                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-3"><strong class="">Georeferencia </strong></div>' +
                                                            '<div class="col-xs-4"><strong >Latitud: <span class="milatitud"></span></strong></div>' +
                                                            '<div class="col-xs-4"><strong >Longitud: <span class="milongitud"></span></strong></div>' +
                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-12 text-center">'+
                                                                '<h3 class="general_content_name text-center">Fotografía del Local Escolar</h3>'+
                                                                '<img src="http://jc.pe/portafolio/cie/cap3/'+codigoid+'/PRED_1/CAP3/'+codigoid+'_1_GPS.jpg" class="foto_img" />'+
                                                            '</div>'+
                                                        '</div>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div id="tab2" class="tab_content" style="display:none;">' +
                                            '<div class="col-xs-12">' +
                                                '<div class="infraestructura">' +
                                                    '<div class="row infra_content">' +
                                                        '<div class="col-xs-6 h3_footer">' +
                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Número predios y edificaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Predios</td><td width="10%">1</td></tr><tr><td width="90%">Edificaciones</td><td width="10%">6</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +

                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Servicios Básicos y Comunicaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Energía eléctrica</td><td width="10%"><img src="<?php echo base_url()?>assets/img/icono/cancel.png" class="" alt=""/></td></tr><tr><td width="90%">Agua potable</td><td width="10%"><img src="<?php echo base_url()?>assets/img/icono/cancel.png" class="" alt=""/></td></tr><tr><td width="90%">Alcantarillado</td><td width="10%"><img src="<?php echo base_url()?>assets/img/icono/success.png" class="" alt=""/></td></tr><tr><td width="90%">Telefonía fija</td><td width="10%"><img src="<?php echo base_url()?>assets/img/icono/success.png" class="" alt=""/></td></tr><tr><td width="90%">Telefonía movil</td><td width="10%"><img src="<?php echo base_url()?>assets/img/icono/success.png" class="" alt=""/></td></tr><tr><td width="90%">internet</td><td width="10%"><img src="<?php echo base_url()?>assets/img/icono/cancel.png" class="" alt=""/></td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +

                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Otras edificaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Patio</td><td width="10%">1</td></tr><tr><td width="90%">Losa deportiva</td><td width="10%">3</td></tr><tr><td width="90%">Cisterna - tanque</td><td width="10%">0</td></tr><tr><td width="90%">Muro de contención</td><td width="10%">0</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +

                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Caracteristicas de las edificaciones</h3>' +
                                                                '<div class="panel-group all_acordion" id="accordion">' +
                                                                    '<div class="panel panel-default all_acordion_chidren">' +
                                                                        '<div class="panel-heading all_acordion_title">' +
                                                                            '<h5 class="panel-title infra_content_name_collapse">' +
                                                                                '<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">' +
                                                                                    'Edificaciones por ejecutor de la obra' +
                                                                                '</a>' +
                                                                            '</h5>' +
                                                                        '</div>' +
                                                                        '<div id="collapseOne" class="panel-collapse collapse in">' +
                                                                            '<div class="panel-body all_acordion_panelBody">' +
                                                                                '<table class="table content_infra_table">' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Gobierno nacional / proyecto especial</td>' +
                                                                                        '<td width="10%">13</td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Apafa / autoconstrucción</td>' +
                                                                                        '<td width="10%">4</td>' +
                                                                                    '</tr>' +
                                                                                '</table>' +
                                                                            '</div>' +
                                                                        '</div>' +
                                                                    '</div>' +
                                                                    '<div class="panel panel-default all_acordion_chidren">' +
                                                                        '<div class="panel-heading all_acordion_title">' +
                                                                            '<h5 class="panel-title infra_content_name_collapse">' +
                                                                                '<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">' +
                                                                                    'Edificaciones segun año de construcción' +
                                                                                '</a>' +
                                                                            '</h5>' +
                                                                        '</div>' +
                                                                        '<div id="collapseTwo" class="panel-collapse collapse">' +
                                                                            '<div class="panel-body all_acordion_panelBody">' +
                                                                                '<table class="table content_infra_table">' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Entre 1978 y 1998</td>' +
                                                                                        '<td width="10%">13</td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Después de 1998</td>' +
                                                                                        '<td width="10%">4</td>' +
                                                                                    '</tr>' +
                                                                                '</table>' +
                                                                            '</div>' +
                                                                        '</div>' +
                                                                    '</div>' +
                                                                    '<div class="panel panel-default all_acordion_chidren">' +
                                                                        '<div class="panel-heading all_acordion_title">' +
                                                                            '<h5 class="panel-title infra_content_name_collapse">' +
                                                                                '<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">' +
                                                                                    'Intervención a realizar' +
                                                                                '</a>' +
                                                                            '</h5>' +
                                                                        '</div>' +
                                                                        '<div id="collapseThree" class="panel-collapse collapse">' +
                                                                            '<div class="panel-body all_acordion_panelBody">' +
                                                                                '<table class="table content_infra_table">' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Número de edificaciones para mantenimiento</td>' +
                                                                                        '<td width="10%">4</td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Número de edificaciones para reforzamiento estructural</td>' +
                                                                                        '<td width="10%">0</td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Número de edificaciones para demolición</td>' +
                                                                                        '<td width="10%">13</td>'+
                                                                                    '</tr>'+
                                                                                '</table>'+
                                                                            '</div>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</div>' +

                                                        '</div>' +
                                                        '<div class="col-xs-6 h3_footer">' +

                                                            '<div class="col-xs-12 quitar_derecha">' +
                                                                '<h3 class="infra_content_name">ESPACIOS EDUCATIVOS QUE FUNCIONAN EN LAS EDIFICACIONES</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Aula común</td><td width="10%">10</td></tr><tr><td width="90%">Pedagógico</td><td width="10%">3</td></tr><tr><td width="90%">Administrativo</td><td width="10%">2</td></tr><tr><td width="90%">Complementario</td><td width="10%">0</td></tr><tr><td width="90%">Servicios</td><td width="10%">2</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            '<div class="col-xs-12 quitar_derecha">' +
                                                                '<h3 class="infra_content_name">Opinión técnica del evaluador</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Edificaciones para mantenimiento</td><td width="10%">3</td></tr><tr><td width="90%">Edificaciones para rehabilitación</td><td width="10%">2</td></tr><tr><td width="90%">Edificaciones para demolición</td><td width="10%">1</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +

                                                            '<div class="col-xs-12 quitar_derecha" style="margin-bottom: 10px">' +
                                                                '<h3 class="infra_content_name" style="padding: 0;">' +
                                                                    '<table class="table content_infra_table">' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Total de pisos</td>' +
                                                                            '<td width="10%">3</td>' +
                                                                        '</tr>' +
                                                                    '</table>' +
                                                                '</h3>' +
                                                            '</div>'+

                                                            '<div class="col-xs-12 quitar_derecha">' +
                                                                '<h3 class="infra_content_name">Área de terreno</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Área de terreno del local escolar</td><td width="10%">5,238m2</td></tr></table>' +
                                                               '</div>' +
                                                            '</div>' +
                                                        '</div>' +
                                                        '<div class="col-xs-12 h3_footer">' +
                                                            '<h3 class="infra_content_name text-center ">Fuente instituto nacional de estadística e informatica - Censo e infraestructura educativa 2013</h3>' +
                                                        '</div>' +
                                                   '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div id="tab3" class="tab_content" style="display:none;">' +
                                            '<div class="col-xs-12 text-center">'+
                                                '<h3 class="general_content_name text-center">Croquis de Ubicación</h3>'+
                                                '<img src="http://jc.pe/portafolio/cie/cap4-cap5/Amazonas/C.C/'+codigoid+'/PRED_1/CAP4/'+codigoid+'_1_Croquis.png" class="foto_img_croqui" /><br><br>'+
                                                '<h3 class="general_content_name text-center">Esquema de distribución de espacio por número de piso</h3>'+
                                                '<img src="http://jc.pe/portafolio/cie/cap4-cap5/Amazonas/C.C/'+codigoid+'/PRED_1/CAP5/'+codigoid+'_1_Piso1.png" class="foto_img_croqui" /><br><br>'+
                                            '</div>'+
                                        '</div>' +
                                        '<div id="tab4" class="tab_content" style="display:none;">' +

                                            '<div class="col-xs-12 text-center">'+
                                                '<h3 class="general_content_name text-center">REGISTRO FOTOGRÁFICO</h3>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_A.png" class="foto_img_croqui_toma " />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_B.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_C.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_D.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_E.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_F.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_G.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_H.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_I.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_J.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_K.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_L.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_M.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_N.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                                '<div class="col-xs-4">'+
                                                    '<img src="<?php echo base_url()?>/assets/img/prueba/000043_1_Capitulo_6_O.png" class="foto_img_croqui_toma" />'+
                                                '</div>'+
                                            '</div>' +
                                        '</div>' +
                                    '</div>';
                            contentString += "<div>";
                            infowindow.setContent(contentString);
                            array = e.row['LatitudPunto_UltP'].value.split(",");
                            infolatlng = new google.maps.LatLng(parseFloat(array[0]), parseFloat(array[1]));
                            infowindow.setPosition(infolatlng);
                            infowindow.open(map);
                            google.maps.event.addListener(infowindow, 'domready', function() {
                                $("ul.tabs li").click(function() {
                                    $("ul.tabs li").removeClass("active"); //remuevo la clase active de todos
                                    $(this).addClass("active"); //añado a la actual la clase active
                                    $(".tab_content").hide(); //escondo todo el contenido
                                    var content = $(this).find("a").attr("href"); //obtengo atributo href del link
                                    $(content).fadeIn(); // muestro el contenido
                                    return false; //devuelvo false para el evento click
                                });
                            });
                        });
                        maploaded = true;
                        setTimeout('checkGoogleMap()', 1000);
                    }, 3000);
            }

            //creado por calevano
            function carga_departamento() {
                $('#prov').empty();
                $('#prov').html('<option value="">Seleccione</option>');
                $('#dist').html('<option value="">Seleccione</option>');
                zomCenter = new google.maps.LatLng(-10.089204, -69.802552);
                zom = 6;
                var posicion = $('#depa option:selected').attr('id');
                if (posicion == -1) {
                    zomCenter = new google.maps.LatLng(-11.7866731456649, -76.6324097107669);
                    zom = 8;
                }
                if (capaKml != undefined) {
                    capaKml.setMap(null);
                }
                capaKml = new google.maps.FusionTablesLayer({
                    query: {
                        select: "geometry",
                        from: table_dpto
                    },
                    options: {
                        styleId: 2,
                        templateId: 2
                    }
                });
                capaKml.setMap(map);
                map.setCenter(zomCenter);
                map.setZoom(zom);
            }
            //Fin creado por calevano
            function load_ubigeo(name) {
                var depaSelect = $('#depa option:selected').attr('id');
                var provSelect = $('#prov option:selected').attr('id');
                if (name == 'PROV') {
                    $.getJSON('<?php echo base_url() ?>assets/json/region.json', function(data) {
                        $.each(data.Departamento[depaSelect].PROVINCIA, function(i, nombre) {
                            $("#prov").append('<option id="' + i + '" value="' + nombre.CCPP + '" >' + nombre.Nombre + '</option>');
                        });
                    });
                } else if (name == 'DIST') {
                    $.getJSON('<?php echo base_url() ?>assets/json/region.json', function(data) {
                        $.each(data.Departamento[depaSelect].PROVINCIA[provSelect].DISTRITO, function(i, nombre) {
                            $("#dist").append('<option id="' + i + '" value="' + nombre.CCDI + '" >' + nombre.Nombre + '</option>');
                        });
                    });
                }
            }

            function load_kml_ft(tabla, code) {
                capaKml.setMap(null);
                capaKml = new google.maps.FusionTablesLayer({
                    query: {
                        select: "geometry",
                        from: tabla,
                        where: 'Ubigeo = ' + code
                    },
                    options: {
                        styleId: 2,
                        templateId: 2
                    }
                });
                capaKml.setMap(map);
                var queryText = "SELECT Ubigeo, geometry FROM " + tabla + " WHERE Ubigeo = " + code;
                var encodedQuery = encodeURIComponent(queryText);
                var query = new google.visualization.Query('http://www.google.com/fusiontables/gvizdata?tq=' + encodedQuery);
                query.send(zoomTo);
            }

            function zoomTo(response) {
                if (!response) {
                    alert('no hay respuesta');
                    return;
                }
                if (response.isError()) {
                    alert('Error en la consulta: ' + response.getMessage() + ' ' + response.getDetailedMessage());
                    return;
                }
                FTresponse = response;
                var kml = FTresponse.getDataTable().getValue(0, 1);
                // create a geoXml3 parser for the click handlers
                var geoXml = new geoXML3.parser({
                    map: map,
                    zoom: false
                });
                geoXml.parseKmlString("<Placemark>" + kml + "</Placemark>");
                geoXml.docs[0].gpolygons[0].setMap(null);
                map.fitBounds(geoXml.docs[0].gpolygons[0].bounds);
            }
        </script>
    </head>
    <body>
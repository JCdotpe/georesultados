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
                padding: 0 20px;
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
        </style>
        <!-- script para traer los valores -->
        <script type="text/javascript">
            google.load('visualization', '1', {'packages': ['corechart', 'table', 'geomap']});
            var kmlArray = [];
            var maploaded = false;
            var layer;
            var capaKml;
            var table_dpto = '1GpIA0mBHMTame6QFenQeQCazLW4NiLciy3lfLvSZ';
            var table_prov = '1tmpbIqHGt8ymHU_L_qTEOpzcMHTOh3i_zzvWB7ZQ';
            var table_dist = '1Qvu7A-6HA7TCPVTAJ6xgld_3J7UFBr2SIlbQBz4w';
            var infowindow = new google.maps.InfoWindow({
                size: new google.maps.Size(550, 550)
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
                $('#depa').change(function() {
                    var cod_ubigeo;
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

            function load_fusiontable() {
                if (layer != undefined) {
                    layer.setMap(null);
                }
                if ($('#depa').val() != "") {
                    maploaded = false;
                    checkGoogleMap();
                    tabla = "1be4h6-mmQ8GdQEwGIjn2CE5vVJnuuRZzAKgMPRfa";
                    condicion = ($('#depa').val() != "" && $('#depa').val() != -1) ? " CCDD = '" + $('#depa').val() + "'" : '';
                    condicion += ($('#prov').val() != "") ? " AND CCPP = '" + $('#prov').val() + "'" : '';
                    condicion += ($('#dist').val() != "") ? " AND CCDI = '" + $('#dist').val() + "'" : '';
                    var interval = setInterval(function() {
                        clearInterval(interval);
                        layer = new google.maps.FusionTablesLayer({
                            query: {
                                select: " * ",
                                from: tabla,
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
                                    '<li><a href="#tab3">INFRAESTRUCTURA</a></li>' +
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
                                                            '<div class="col-xs-6"><span class="midirector"></span></div>' +
                                                            '<div class="col-xs-3"><strong class="">Teléfono</strong> <span class="mitelefono"></span></span></div>' +
                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-3"><strong >Dirección </strong></div>' +
                                                            '<div class="col-xs-3"><span class="midireccion"></span></div>' +
                                                            '<div class="col-xs-3"><strong >Departamento</strong></div>' +
                                                            '<div class="col-xs-3"><span class="midepartamento"></span></div>' +
                                                            '<div class="col-xs-3"><strong >Provincia</strong></div>' +
                                                            '<div class="col-xs-3"><span class="miprovincia"></span></div>' +
                                                            '<div class="col-xs-3"><strong >Distrito</strong></div>' +
                                                            '<div class="col-xs-3"><span class="midistrito"></span></div>' +
                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-4"><strong class="">Propietario local </strong></div>' +
                                                            '<div class="col-xs-8"><span class="mipropietariolocal"></span></div>' +
                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-3"><strong class="">Georeferencia </strong></div>' +
                                                            '<div class="col-xs-4"><strong >Latitud: <span class="milatitud"></span></strong></div>' +
                                                            '<div class="col-xs-4"><strong >Longitud: <span class="milongitud"></span></strong></div>' +
                                                        '</div>' +
                                                        '<div class="row name_educativo">' +
                                                            '<div class="col-xs-6 text-right"><strong class="base_medio">Registro fotográfico</strong></div>' +
                                                            '<div class="col-xs-6 text-left"><a href="javascript:;" ><img src="<?php echo base_url() ?>assets/img/icono/camera.png" class="name_educativo_icono"/></a></div>' +
                                                            '<div class="col-xs-12 text-center"><img src="http://jc.pe/portafolio/cie/cap3/'+codigoid+'/PRED_1/CAP3/'+codigoid+'_1_GPS.jpg" width="500" height="375"/></div>'+
                                                        '</div>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div id="tab3" class="tab_content" style="display:none;">' +
                                            '<div class="col-xs-12">' +
                                                '<div class="infraestructura">' +
                                                    '<div class="row infra_content">' +
                                                        '<div class="col-xs-6 h3_footer">' +
                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name "><span class="mipropietariolocal"></span>Servicios Básicos</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td>Energía eléctrica</td></tr><tr><td>Agua potable</td></tr><tr><td>Alcantarillado</td></tr><tr><td>Telefonía fija</td></tr><tr><td>Telefonía movil</td></tr><tr><td>internet</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Espacios educativos</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Aula común</td><td width="10%">10</td></tr><tr><td width="90%">Pedagógico</td><td width="10%">3</td></tr><tr><td width="90%">Administrativo</td><td width="10%">2</td></tr><tr><td width="90%">Complementario</td><td width="10%">0</td></tr><tr><td width="90%">Servicios</td><td width="10%">2</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Opinión técnica del evaluador</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Edificaciones para mantenimiento</td><td width="10%">3</td></tr><tr><td width="90%">Edificaciones para rehabilitación</td><td width="10%">2</td></tr><tr><td width="90%">Edificaciones para demolición</td><td width="10%">1</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                        '</div>' +
                                                        '<div class="col-xs-6 h3_footer">' +
                                                            '<div class="col-xs-12 quitar_derecha">' +
                                                                '<h3 class="infra_content_name">Defensa civil</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Con edificaciones inspeccionadas</td><td width="90%">3</td></tr><tr><td width="90%">Con edificaciones declaradas inhabitables alto riesgo</td><td width="90%">1</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            '<div class="col-xs-12 quitar_derecha">' +
                                                                '<h3 class="infra_content_name">Peligros asociados a la ubicación de la localidad</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td>Peligros naturales</td></tr><tr><td>Peligros socionaturales</td></tr><tr><td>peligros antropicos</td></tr><tr><td>Vulnerabilidad por factores de exposicion</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            '<div class="col-xs-12 quitar_derecha">' +
                                                                '<h3 class="infra_content_name">Otras edificaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Patio</td><td width="10%">1</td></tr><tr><td width="90%">Losa deportiva</td><td width="10%">3</td></tr><tr><td width="90%">Cisterna - tanque</td><td width="10%">0</td></tr><tr><td width="90%">Muro de contención</td><td width="10%">0</td></tr></table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            '<div class="col-xs-12 quitar_derecha">' +
                                                                '<h3 class="infra_content_name">Número predios y edificaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table"><tr><td width="90%">Predios</td><td width="10%">1</td></tr><tr><td width="90%">Edificaciones</td><td width="10%">6</td></tr></table>' +
                                                               '</div>' +
                                                            '</div>' +
                                                        '</div>' +
                                                        '<div class="col-xs-12 h3_footer">' +
                                                            '<h3 class="infra_content_name text-center ">Fuente instituto nacional de estadistica e informatica - Censo e infraestructura educativa 2014</h3>' +
                                                        '</div>' +
                                                   '</div>' +
                                                '</div>' +
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
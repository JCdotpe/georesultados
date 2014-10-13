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
        <script type="text/javascript">
            $(document).ready(function() {
                $(".tooltip_info").tooltip({
                    placement: 'right'
                });
            });
        </script>
        <script type="text/javascript">
            $(function() {
                $(".search").keyup(function() {
                    var inputSearch = $(this).val();
                    var dataString = 'searchword=' + inputSearch;
                    if (inputSearch != '') {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>buscarIE",
                            data: dataString,
                            cache: false,
                            success: function(data) {
                                $("#divResult").html(data).show();
                            }
                        });
                    }
                    return false;
                });

                $("#divResult").on("click", function(e) {
                    
                    var $clicked = $(e.target);
                    var $name = $clicked.find('.name').html();
                    var decoded = $("<div/>").html($name).text();
                    $('#searchColegio').val(decoded);
                    
                    var $clicked_2 = $(e.target);
                    var $name_2 = $clicked_2.find('.hiddenColegio').html();
                    var decoded_2 = $("<div/>").html($name_2).text();
                    $('#hiddenColegioCodigo').text(decoded_2);
                });
                $(document).on("click", function(e) {
                    var $clicked = $(e.target);
                    if (!$clicked.hasClass("search")) {
                        $("#divResult").fadeOut();
                    }
                });
                $('#searchColegio').click(function() {
                    $(this).select();
                    if($(".search").val() !=""){
                        $("#divResult").fadeIn();
                    }
                });
            });
        </script>
        <style type="text/css">
            .tooltip_info{
                cursor: pointer;
            }
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
                border-radius: 5px 5px 0 0 ;
                -webkit-border-radius: 5px 5px 0 0 ;
                -moz-border-radius: 5px 5px 0 0 ;
                margin-bottom: 0;
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
            
            .infra_content_name_collapse:hover{
                color:#1a4f83;
                font-weight: bold;
            }
            
            .all_acordion_title a:hover{
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
            
            .panel-heading .accordion-toggle:before {
                font-family: 'Glyphicons Halflings'; 
                content: "\e114";
                float: right;
                color: grey;
            }
            .panel-heading .accordion-toggle.collapsed:before {
                content: "\e080"; 
            }
            
            .contentArea{
                width:600px;
                margin:0 auto;
            }
            #inputSearch{
                width:350px;
                border:solid 1px #000;
                padding:3px;
            }
            #divResult{
                z-index: 99999999;
                position:absolute;
                width:350px;
                display:none;
                margin-top:31px;
                border:solid 1px #dedede;
                border-top:0px;
                overflow:hidden;
                border-bottom-right-radius: 6px;
                border-bottom-left-radius: 6px;
                -moz-border-bottom-right-radius: 6px;
                -moz-border-bottom-left-radius: 6px;
                box-shadow: 0px 0px 5px #999;
                border-width: 3px 1px 1px;
                background-color: white;
            }
            .display_box{
                padding:4px; border-top:solid 1px #dedede; 
                font-size:12px; height:50px;
            }
            .display_box:hover{
                background: #00A1C7;
                color:#FFFFFF;
                cursor:pointer;
            }
            .descar_info{
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-radius: 5px 5px 0 0;
                font-size: 16px;
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
                        $("#dv_download").hide();
                        alert("Ingrese código");
                        $('#searchCodigo').focus();
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
                                $('#searchCodigo').focus().select();
                                initialize();
                            }else{
                                $("#dv_download").slideDown('slow');
                                $("#btnDonwload").attr("href","<?php echo base_url()?>exportar/csvexport/por_Codigo?idCodigo=" + codLocal);
                                var result = JSON.parse(data);
                                $.each(result, function(i, datos) {
                                    var latitud = datos.LatitudPunto_UltP;
                                    var longitud = datos.LongitudPunto_UltP;
                                    var puntokml = datos.cod_dpto+datos.cod_prov+datos.cod_dist;
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
                
                $("#btnFindColegio").click(function(){
                
                    var codLocal_1 = $('#hiddenColegioCodigo').text().trim();
                    //alert(codLocal_1);
                    if (codLocal_1 == "") {
                        alert("Ingrese el nombre de la Institución");
                        $('#searchColegio').focus();
                    } else {
                        $('#prov').empty();
                        $("#prov").append('<option value="">Seleccione</option>');
                        $("#dv_prov .select2-chosen").text("Seleccione");
                        $("#dv_dist .select2-chosen").text("Seleccione");
                        $('#depa option:selected').val("");
                        $("#dv_dep .select2-chosen").text("Seleccione");
                        carga_departamento();
                        var url_1 = "<?php echo base_url() ?>home/getBubble?idCodigo=" + codLocal_1;
                        $.get(url_1, function(data_1) {
                            var result_1 = JSON.parse(data_1);
                            $.each(result_1, function(i, datos_1) {
                                var latitud_1 = datos_1.LatitudPunto_UltP;
                                var longitud_1 = datos_1.LongitudPunto_UltP;
                                var puntokml_1 = datos_1.cod_dpto+datos_1.cod_prov+datos_1.cod_dist;
                                console.log(codLocal_1+" ");
                                console.log(puntokml_1);
                                load_kml_ft(table_dist, puntokml_1);

                                zomCenter_1 = new google.maps.LatLng(latitud_1, longitud_1);
                                zom_1 = 8;
                                map.setCenter(zomCenter_1);
                                map.setZoom(zom_1);
                            });
                            var query = " id_local = '" + codLocal_1 + "' ";

                            load_fusiontable(query);
                            
                        });
                    }
                });
                
                

                $('#depa').change(function() {
                    var cod_ubigeo;
                    $('#searchCodigo').val("");
                    
                    $('#optCodigo000043').attr("checked",false);
                    $('#optColegio').attr("checked",false);
                    $('#searchColegio').val("");
                    $('#dv_searchColegio').hide();
                    $('#dv_search').hide();
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
                                    //General
                                    /*'<img src="http://jc.pe/portafolio/cie/cap3/'+codigoid+'/PRED_1/CAP3/'+codigoid+'_1_GPS.jpg" class="foto_img" />'+ */
                                    $("#btnDonwload").attr("href","<?php echo base_url()?>exportar/csvexport/por_Codigo?idCodigo=" + codigoid);
                                    if(datos.RutaFoto !=null){
                                        $('.gen_rutaFoto').append('<div class="row name_educativo"><div class="col-xs-12 text-center"><h3 class="general_content_name text-center" style="margin-bottom:10px">Fotografía del Local Escolar</h3><img src="http://jc.pe/portafolio/cie/cap3/'+datos.RutaFoto+'" class="foto_img" /></div></div>');
                                    }else{
                                        $('.gen_rutaFoto').append('');
                                    }
                                    $('.gen_codLocal').append(datos.codigo_de_local);
                                    $('.gen_nombreIE').append(datos.nombres_IIEE);
                                    $('.gen_latitud').append(datos.LatitudPunto_UltP);
                                    $('.gen_longitud').append(datos.LongitudPunto_UltP);
                                    if( datos.prop_IE == null){  $('.gen_proLocal').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.gen_proLocal').append(datos.prop_IE);}
                                    $('.gen_direccionIE').append(datos.direcc_IE);
                                    $('.gen_departLocal').append(datos.dpto_nombre);
                                    $('.gen_provLocal').append(datos.prov_nombre);
                                    $('.gen_distLocal').append(datos.dist_nombre);
                                    $('.gen_dirLocal').append(datos.Director_IIEE);
                                    $('.gen_nivEducativo').append(datos.nivel);
                                    $('.gen_areaLocal').append(datos.des_area);
                                    $('.micentropoblado').append(datos.centroPoblado);
                                    if( datos.Talum == 0 ){ $('.gen_countAlumnos').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{$('.gen_countAlumnos').append(datos.Talum);}
                                    if( datos.tel_IE == null){ $('.gen_telLocal').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{$('.gen_telLocal').append(datos.tel_IE);}
                                    //Infraestructura
                                    //--Numero de predios y edificaciones
                                    if( datos.cPred == 0){ $('.inf_numPredios').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_numPredios').append(datos.cPred);}
                                    if( datos.cEdif== 0){ $('.inf_numEdificaciones').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_numEdificaciones').append(datos.cEdif);}
                                    if( (datos.Piso ==null) || (datos.Piso== 0)){ $('.inf_countPiso').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_countPiso').append(datos.Piso); }
                                    if( datos.P1_B_3_9_At_Local== null){ $('.inf_areTerreno').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_areTerreno').append(datos.P1_B_3_9_At_Local);}                                    
                                    //--Otras edificaciones
                                    if( datos.P== 0){ $('.inf_numPatios').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_numPatios').append(datos.P);}
                                    if( datos.LD== 0){ $('.inf_numLosDeportivas').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_numLosDeportivas').append(datos.LD);}
                                    if( datos.CTE== 0){ $('.inf_numCisTanques').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_numCisTanques').append(datos.CTE);}
                                    if( datos.MC== 0){$('.inf_numMurContencion').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_numMurContencion').append(datos.MC);}
                                    //--Servicios basicos y comunicaciones
                                    if( (datos.P2_C_2LocE_1_Energ== null) || (datos.P2_C_2LocE_1_Energ ==2)){ $('.inf_serBasEnerElec').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{$('.inf_serBasEnerElec').append(datos.P2_C_2LocE_1_Energ); }
                                    if( (datos.P2_C_2LocE_2_Agua== null) || (datos.P2_C_2LocE_2_Agua ==2)){$('.inf_aguPtable').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_aguPtable').append(datos.P2_C_2LocE_2_Agua);}
                                    if( (datos.P2_C_2LocE_3_Alc== null) || (datos.P2_C_2LocE_3_Alc ==2)){ $('.inf_alcantarillado').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_alcantarillado').append(datos.P2_C_2LocE_3_Alc);}
                                    if( (datos.P2_C_2LocE_4_Tfija== null) || (datos.P2_C_2LocE_4_Tfija ==2)){ $('.inf_telFija').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_telFija').append(datos.P2_C_2LocE_4_Tfija);}
                                    if( (datos.P2_C_2LocE_5_Tmov== null) || (datos.P2_C_2LocE_5_Tmov ==2)){$('.inf_telMovil').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_telMovil').append(datos.P2_C_2LocE_5_Tmov);}
                                    if( (datos.P2_C_2LocE_6_Int== null) || (datos.P2_C_2LocE_6_Int ==2)){$('.inf_internet').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_internet').append(datos.P2_C_2LocE_6_Int);}
                                    //--Espacios educativos que funcionan en las edificaciones
                                    if( datos.e_1== 0){ $('.inf_aulComun').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_aulComun').append(datos.e_1);}
                                    if( datos.e_2== 0){ $('.inf_pedagogico').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_pedagogico').append(datos.e_2);}
                                    if( datos.e_3== 0){ $('.inf_administrativo').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_administrativo').append(datos.e_3);}
                                    if( datos.e_4== 0){ $('.inf_complementario').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_complementario').append(datos.e_4);}
                                    if( datos.e_5== 0){ $('.inf_servicio').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_servicio').append(datos.e_5);}
                                    //--Características de las edificaciones
                                    if( datos.eo_1== 0){ $('.inf_gobNacional').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_gobNacional').append(datos.eo_1);}
                                    if( datos.eo_3== 0){ $('.inf_apafa').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{$('.inf_apafa').append(datos.eo_3); }
                                    if( datos.a_2== 0){ $('.inf_entre').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_entre').append(datos.a_2);}
                                    if( datos.a_3== 0){ $('.inf_despues').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_despues').append(datos.a_3);}
                                    if( datos.eman== 0){ $('.inf_countEdiMante').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_countEdiMante').append(datos.eman);}
                                    if( datos.ereh== 0){ $('.inf_countEdiEstruc').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_countEdiEstruc').append(datos.ereh);}
                                    if( datos.edem== 0){ $('.inf_countEdiDemo').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_countEdiDemo').append(datos.edem);}
                                });
                            });

                            contentString += '<ul class="tabs">' +
                                    '<li class="active"><a href="#tab1">GENERAL</a></li>' +
                                    '<li><a href="#tab2">INFRAESTRUCTURA</a></li>' +
                                    '<li><a href="#tab4">TOMAS FOTOGRÁFICAS</a></li>' +
                                    '</ul>' +
                                    '<div class="tab_container">' +
                                        '<div id="tab1" class="tab_content">' +
                                            '<div class="col-xs-12 h3_footer">' +
                                                '<div class="general">' +
                                                    '<div class="general_content">' +
                                                        '<a href="" class="col-xs-12 btn btn-success btn-sm descar_info" id="btnDonwload"><i class="glyphicon glyphicon-download"></i> Descargar información</a>' +
                                                        '<h3 class="general_content_name text-center">Principales características del local escolar<br/>código del local escolar n° <span class="gen_codLocal"></span></h3>' +
                                                        
                                                        '<div class="panel-group all_acordion" id="accordion_gen">' +
                                                            '<div class="panel  panel-default all_acordion_chidren">' +
                                                                '<div class="panel-heading all_acordion_title">' +
                                                                    '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_gen" href="#collapseOne_gen_1">' +
                                                                        '<h5 class="panel-title infra_content_name_collapse">' +
                                                                            'Institución educativa que presta servicios en el local escolar' +
                                                                        '</h5>' +
                                                                    '</a>' +
                                                                '</div>' +
                                                                '<div id="collapseOne_gen_1" class="panel-collapse collapse in">' +
                                                                    '<div class="panel-body all_acordion_panelBody">' +
                                                                        '<table class="table content_infra_table">' +
                                                                            '<tr>' +
                                                                                '<td width="40%">Nombre de la I.E</td>' +
                                                                                '<td width="60%"><strong><span class="gen_nombreIE"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="40%">Nombre del director</td>' +
                                                                                '<td width="60%"><strong><span class="gen_dirLocal"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="40%">Teléfono</td>' +
                                                                                '<td width="60%"><strong><span class="gen_telLocal"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="40%">Nivel Educativo</td>' +
                                                                                '<td width="60%"><strong><span class="gen_nivEducativo"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="40%">Propietario del predio</td>' +
                                                                                '<td width="60%"><strong><span class="gen_proLocal"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="40%">Número de alumnos</td>' +
                                                                                '<td width="60%"><strong><span class="gen_countAlumnos"></span></strong></td>' +
                                                                            '</tr>' +
                                                                        '</table>' +
                                                                    '</div>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            
                                                            '<div class="panel panel-default all_acordion_chidren">' +
                                                                '<div class="panel-heading all_acordion_title">' +
                                                                    '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_gen" href="#collapseTwo_gen_2">' +
                                                                        '<h5 class="panel-title infra_content_name_collapse">' +
                                                                            'Ubicación geográfica' +
                                                                        '</h5>' +
                                                                    '</a>' +
                                                                '</div>' +
                                                                '<div id="collapseTwo_gen_2" class="panel-collapse collapse">' +
                                                                    '<div class="panel-body all_acordion_panelBody">' +
                                                                        '<table class="table content_infra_table">' +
                                                                            '<tr>' +
                                                                                '<td width="30%">Departamento</td>' +
                                                                                '<td width="70%"><strong><span class="gen_departLocal"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="30%">Provincia</td>' +
                                                                                '<td width="70%"><strong><span class="gen_provLocal"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="30%">Distrito</td>' +
                                                                                '<td width="70%"><strong><span class="gen_distLocal"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="30%">Centro poblado</td>' +
                                                                                '<td width="70%"><strong><span class="micentropoblado"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="30%">Área</td>' +
                                                                                '<td width="70%"><strong><span class="gen_areaLocal"></span></strong></td>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td width="30%">Dirección</td>' +
                                                                                '<td width="70%"><strong><span class="gen_direccionIE"></span></strong></td>' +
                                                                            '</tr>' + 
                                                                            '<tr>' +
                                                                                '<td width="30%">Georeferenciación</td>' +
                                                                                '<td width="70%">Latitud <strong style="margin-right:20px"><span class="gen_latitud"></span></strong> Longitud <strong><span class="gen_longitud"></span></strong></td>' +
                                                                            '</tr>' +
                                                                        '</table>' +
                                                                    '</div>' +
                                                                '</div>' +
                                                            '</div>' +
                                                        '</div>'+
                                                        
                                                        '<div class="gen_rutaFoto"></div>'+
                                                        
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        
                                        '<div id="tab2" class="tab_content" style="display:none;">' +
                                            '<div class="col-xs-12">' +
                                                '<div class="infraestructura">' +
                                                    '<div class="row infra_content">' +
                                                        '<a href="" class="col-xs-12 btn btn-success btn-sm descar_info" id="btnDonwload"><i class="glyphicon glyphicon-download"></i> Descargar información</a>' +
                                                        '<div class="col-xs-6 h3_footer">' +
                                                            
                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Número predios y edificaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table">'+
                                                                        '<tr>'+
                                                                            '<td width="80%">Predios</td>'+
                                                                            '<td width="20%"><strong><span class="inf_numPredios"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>'+
                                                                            '<td width="80%">Edificaciones</td>'+
                                                                            '<td width="20%"><strong><span class="inf_numEdificaciones"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>' +
                                                                            '<td width="80%">Total de pisos</td>' +
                                                                            '<td width="20%"><strong><span class="inf_countPiso"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="80%">Área del terreno</td>' +
                                                                            '<td width="20%"><strong><span class="inf_areTerreno"></span></strong></td>' +
                                                                        '</tr>' +
                                                                    '</table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            
                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Otras edificaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table">' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Patio</td>' +
                                                                            '<td width="10%"><strong><span class="inf_numPatios"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Losa deportiva</td>' +
                                                                            '<td width="10%"><strong><span class="inf_numLosDeportivas"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Cisterna - tanque</td>' +
                                                                            '<td width="10%"><strong><span class="inf_numCisTanques"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Muro de contención</td>' +
                                                                            '<td width="10%"><strong><span class="inf_numMurContencion"></span></strong></td>' +
                                                                        '</tr>' +
                                                                    '</table>' +
                                                                '</div>' +
                                                            '</div>' +

                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Servicios Básicos y Comunicaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table">'+
                                                                        '<tr>'+
                                                                            '<td width="90%">Energía eléctrica</td>'+
                                                                            '<td width="10%"><strong><span class="inf_serBasEnerElec"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>'+
                                                                            '<td width="90%">Agua potable</td>'+
                                                                            '<td width="10%"><strong><span class="inf_aguPtable"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>'+
                                                                            '<td width="90%">Alcantarillado</td>'+
                                                                            '<td width="10%"><strong><span class="inf_alcantarillado"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>'+
                                                                            '<td width="90%">Telefonía fija</td>'+
                                                                            '<td width="10%"><strong><span class="inf_telFija"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>'+
                                                                            '<td width="90%">Telefonía movil</td>'+
                                                                            '<td width="10%"><strong><span class="inf_telMovil"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>'+
                                                                            '<td width="90%">Internet</td>'+
                                                                            '<td width="10%"><strong><span class="inf_internet"></span></strong></td>'+
                                                                        '</tr>'+
                                                                    '</table>' +
                                                                '</div>' +
                                                            '</div>' +

                                                        '</div>' +
                                                        '<div class="col-xs-6 h3_footer">' +

                                                            '<div class="col-xs-12 h3_footer">' +
                                                                '<h3 class="infra_content_name">ESPACIOS EDUCATIVOS QUE FUNCIONAN EN LAS EDIFICACIONES</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table">' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Aula común</td>' +
                                                                            '<td width="10%"><strong><span class="inf_aulComun"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Pedagógico</td>' +
                                                                            '<td width="10%"><strong><span class="inf_pedagogico"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Administrativo</td>' +
                                                                            '<td width="10%"><strong><span class="inf_administrativo"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Complementario</td>' +
                                                                            '<td width="10%"><strong><span class="inf_complementario"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Servicios</td>' +
                                                                            '<td width="10%"><strong><span class="inf_servicio"></span></strong></td>' +
                                                                        '</tr>' +
                                                                    '</table>' +
                                                                '</div>' +
                                                            '</div>' +
                                                            
                                                            '<div class="col-xs-12 h3_footer">' +
                                                                '<h3 class="infra_content_name">Caracteristicas de las edificaciones</h3>' +
                                                                '<div class="panel-group all_acordion" id="accordion">' +
                                                                    '<div class="panel panel-default all_acordion_chidren">' +
                                                                        '<div class="panel-heading all_acordion_title">' +
                                                                            '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_1">' +
                                                                                '<h5 class="panel-title infra_content_name_collapse">' +
                                                                                    'Edificaciones por ejecutor de la obra' +
                                                                                '</h5>' +
                                                                            '</a>' +
                                                                        '</div>' +
                                                                        '<div id="collapseOne_1" class="panel-collapse collapse in">' +
                                                                            '<div class="panel-body all_acordion_panelBody">' +
                                                                                '<table class="table content_infra_table">' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Gobierno nacional / proyecto especial</td>' +
                                                                                        '<td width="10%"><strong><span class="inf_gobNacional"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Apafa / autoconstrucción</td>' +
                                                                                        '<td width="10%"><strong><span class="inf_apafa"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                '</table>' +
                                                                            '</div>' +
                                                                        '</div>' +
                                                                    '</div>' +
                                                                    '<div class="panel panel-default all_acordion_chidren">' +
                                                                        '<div class="panel-heading all_acordion_title">' +
                                                                            '<a class="accordion-toggle" data-toggle="collapse"  data-parent="#accordion" href="#collapseTwo_2">' +
                                                                                '<h5 class="panel-title infra_content_name_collapse">' +
                                                                                    'Edificaciones segun año de construcción' +
                                                                                '</h5>' +
                                                                            '</a>' +
                                                                        '</div>' +
                                                                        '<div id="collapseTwo_2" class="panel-collapse collapse">' +
                                                                            '<div class="panel-body all_acordion_panelBody">' +
                                                                                '<table class="table content_infra_table">' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Entre 1978 y 1998</td>' +
                                                                                        '<td width="10%"><strong><span class="inf_entre"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Después de 1998</td>' +
                                                                                        '<td width="10%"><strong><span class="inf_despues"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                '</table>' +
                                                                            '</div>' +
                                                                        '</div>' +
                                                                    '</div>' +
                                                                    '<div class="panel panel-default all_acordion_chidren">' +
                                                                        '<div class="panel-heading all_acordion_title">' +
                                                                            '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree_3">' +
                                                                                '<h5 class="panel-title infra_content_name_collapse">' +
                                                                                    'Intervención a realizar' +
                                                                                '</h5>' +
                                                                            '</a>' +
                                                                        '</div>' +
                                                                        '<div id="collapseThree_3" class="panel-collapse collapse">' +
                                                                            '<div class="panel-body all_acordion_panelBody">' +
                                                                                '<table class="table content_infra_table">' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Número de edificaciones para mantenimiento</td>' +
                                                                                        '<td width="10%"><strong><span class="inf_countEdiMante"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Número de edificaciones para reforzamiento estructural</td>' +
                                                                                        '<td width="10%"><strong><span class="inf_countEdiEstruc"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Número de edificaciones para demolición</td>' +
                                                                                        '<td width="10%"><strong><span class="inf_countEdiDemo"></span></strong></td>'+
                                                                                    '</tr>'+
                                                                                '</table>'+
                                                                            '</div>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</div>' +
                                                            
                                                        '</div>' +
                                                        '<div class="col-xs-12 h3_footer" >' +
                                                            '<h3 class="infra_content_name text-center" style="border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px;">Fuente instituto nacional de estadística e informatica - Censo e infraestructura educativa 2013</h3>' +
                                                        '</div>' +
                                                   '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        
                                        '<div id="tab4" class="tab_content" style="display:none;">' +
                                            '<div class="col-xs-12 text-center">'+
                                                '<a href="" class="col-xs-12 btn btn-success btn-sm descar_info" id="btnDonwload"><i class="glyphicon glyphicon-download"></i> Descargar información</a>' +
                                                '<h3 class="general_content_name text-center" style="margin-bottom: 10px;">REGISTRO FOTOGRÁFICO</h3>'+
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
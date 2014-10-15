<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo (isset($titulo) and $titulo != "") ? $titulo . " | " : ""; ?>INEI</title>
        <!-- Enlace a estilos -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
        <link type="text/css" href="<?php echo base_url() ?>assets/css/bootswatch.min.css" rel="stylesheet" />
        <link type="text/css" href="<?php echo base_url() ?>assets/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/select2.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/maps.css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
        
        <!-- Enlace a Javascript -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/facebox/src/facebox.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        
        
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/global.js"></script>
        
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript" src="http://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('a[rel*=facebox]').facebox();
                $(".tooltip_info").tooltip({
                    placement: 'right'
                });
                $('#facebox').draggable({handle:'div.titulo'});
            });
        </script>
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
                size: new google.maps.Size(650, 550)
            });
            function checkGoogleMap() {
                var msg = document.getElementById('msg');
                if (maploaded == false) {
                    msg.innerHTML = '<strong>Cargando Puntos<img src="<?php echo base_url()?>assets/img/294.gif" /></strong>';
                    $("#msg").slideDown("fast");
                } else {
                    msg.innerHTML = '<strong>Puntos Cargados<img src="<?php echo base_url()?>assets/img/08.gif" /></strong>';
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

//                $("#btnFindCodLocal").click(function() {
//                    var codLocal = $('#searchCodigo').val();
//                    if (codLocal == "") {
//                        alert("Ingrese código");
//                        $('#searchCodigo').focus();
//                    } else {
//                        $('#prov').empty();
//                        $("#prov").append('<option value="">Seleccione</option>');
//                        $("#dv_prov .select2-chosen").text("Seleccione");
//                        $("#dv_dist .select2-chosen").text("Seleccione");
//                        $('#depa option:selected').val("");
//                        $("#dv_dep .select2-chosen").text("Seleccione");
//                        carga_departamento();
//                        var url = "<?php echo base_url() ?>home/getBubble?idCodigo=" + codLocal;
//                        $.get(url, function(data) {
//                            if(data.length==2){
//                                alert("Código incorrecto");
//                                $('#searchCodigo').focus().select();
//                                initialize();
//                            }else{
//                                $("#dv_download").slideDown('slow');
//                                $("#btnDonwload").attr("href","<?php echo base_url()?>exportar/csvexport/por_Codigo?idCodigo=" + codLocal);
//                                var result = JSON.parse(data);
//                                $.each(result, function(i, datos) {
//                                    var latitud = datos.LatitudPunto_UltP;
//                                    var longitud = datos.LongitudPunto_UltP;
//                                    var puntokml = datos.cod_dpto+datos.cod_prov+datos.cod_dist;
//                                    console.log(puntokml);
//                                    load_kml_ft(table_dist, puntokml);
//
//                                    zomCenter = new google.maps.LatLng(latitud, longitud);
//                                    zom = 8;
//                                    map.setCenter(zomCenter);
//                                    map.setZoom(zom);
//                                });
//                                var query = " id_local = '" + codLocal + "' ";
//
//                                load_fusiontable(query);
//                            }
//                        });
//                    }
//                });
                
//                $("#btnFindColegio").click(function(){
//                
//                    var codLocal_1 = $('.hiddenColegioCodigo').text().trim();
//                    //alert(codLocal_1);
//                    if (codLocal_1 == "") {
//                        alert("Ingrese el nombre de la Institución");
//                        $('.searchColegio').focus();
//                    } else {
//                        $('#prov').empty();
//                        $("#prov").append('<option value="">Seleccione</option>');
//                        $("#dv_prov .select2-chosen").text("Seleccione");
//                        $("#dv_dist .select2-chosen").text("Seleccione");
//                        $('#depa option:selected').val("");
//                        $("#dv_dep .select2-chosen").text("Seleccione");
//                        carga_departamento();
//                        var url_1 = "<?php echo base_url() ?>home/getBubble?idCodigo=" + codLocal_1;
//                        $.get(url_1, function(data_1) {
//                            var result_1 = JSON.parse(data_1);
//                            $.each(result_1, function(i, datos_1) {
//                                var latitud_1 = datos_1.LatitudPunto_UltP;
//                                var longitud_1 = datos_1.LongitudPunto_UltP;
//                                var puntokml_1 = datos_1.cod_dpto+datos_1.cod_prov+datos_1.cod_dist;
//                                console.log(codLocal_1+" ");
//                                console.log(puntokml_1);
//                                load_kml_ft(table_dist, puntokml_1);
//
//                                zomCenter_1 = new google.maps.LatLng(latitud_1, longitud_1);
//                                zom_1 = 8;
//                                map.setCenter(zomCenter_1);
//                                map.setZoom(zom_1);
//                            });
//                            var query = " id_local = '" + codLocal_1 + "' ";
//
//                            load_fusiontable(query);
//                            
//                        });
//                    }
//                });
                
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
//                        cod_ubigeo = $(this).val();

                        //load_kml_ft(table_dpto, cod_ubigeo);
                    } else if ($(this).val() == -1) {
                        carga_departamento();
                    }
                    //load_fusiontable();
                });
                $('#prov').change(function() {
                    var cod_ubigeo;
                    $("#dist").empty();
                    $("#dist").append('<option value="">Seleccione</option>');
                    $("#dv_dist .select2-chosen").text("Seleccione");
                    if ($(this).val() != "") {
                        load_ubigeo('DIST');
                    }
//                    if ($(this).val() != "") {
//                        cod_ubigeo = $('#depa').val() + $(this).val();
//
//                        load_kml_ft(table_prov, cod_ubigeo);
//                    } else {
//                        load_kml_ft(table_dpto, $('#depa').val());
//                    }
                    //load_fusiontable();
                });
                $('#dist').change(function() {
//                    var cod_ubigeo;
//                    if ($(this).val() != "") {
//                        cod_ubigeo = $('#depa').val() + $('#prov').val() + $(this).val();
//
//                        load_kml_ft(table_dist, cod_ubigeo);
//                    } else {
//                        cod_ubigeo = $('#depa').val() + $('#prov').val();
//
//                        load_kml_ft(table_prov, cod_ubigeo);
//                    }
//                    load_fusiontable();
                });
            });

            function load_fusiontable(query) {
                query = query || "";
                if (layer != undefined) {
                    layer.setMap(null);
                }
                //if($('#searchCodigo').val() !="" && $('#depa').val() == ""){
                if($('#searchCodigo').val() !=""){
                    maploaded = false;
                    checkGoogleMap();
                    condicion = query;
                    cargar_tabs();
                }
                
                if($('#searchColegio').val() !=""){
                    maploaded = false;
                    checkGoogleMap();
                    condicion = query;
                    cargar_tabs();
                }
                
                
                if ($('#depa').val() != "") {
                    maploaded = false;
                    checkGoogleMap();
                    condicion = query;
//                    condicion = ($('#depa').val() != "" && $('#depa').val() != -1) ? " CCDD = '" + $('#depa').val() + "'" : '';
//                    condicion += ($('#prov').val() != "") ? " AND CCPP = '" + $('#prov').val() + "'" : '';
//                    condicion += ($('#dist').val() != "") ? " AND CCDI = '" + $('#dist').val() + "'" : '';
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
                                    $(".btnDonwload").attr("href","<?php echo base_url()?>exportar/csvexport/por_Codigo?idCodigo=" + codigoid);
                                    
                                    //--Insitución educativa que presta servicios en el lcal escolar
                                    $('.gen_codLocal').append(datos.codigo_de_local);
                                    $('.gen_nombreIE').append(datos.nombres_IIEE);
                                    $('.gen_direccionIE').append(datos.direcc_IE);
                                    if( datos.tel_IE == null){$('.gen_telLocal').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{$('.gen_telLocal').append(datos.tel_IE);}
                                    $('.gen_nivEducativo').append(datos.nivel);
                                    if( datos.prop_IE == null){$('.gen_proLocal').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{$('.gen_proLocal').append(datos.prop_IE);}
                                    if( datos.Talum == 0 ){$('.gen_countAlumnos').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{$('.gen_countAlumnos').append(datos.Talum);}
                                    
                                    //--Ubicación geografica                                    
                                    $('.gen_departLocal').append(datos.dpto_nombre);
                                    $('.gen_provLocal').append(datos.prov_nombre);
                                    $('.gen_distLocal').append(datos.dist_nombre);
                                    $('.micentropoblado').append(datos.centroPoblado);
                                    $('.gen_areaLocal').append(datos.des_area);
                                    $('.gen_dirLocal').append(datos.Director_IIEE);
                                    $('.gen_latitud').append(datos.LatitudPunto_UltP);
                                    $('.gen_longitud').append(datos.LongitudPunto_UltP);
                                    $('.gen_altitud').append(datos.AltitudPunto_UltP+" msnm");
                                    
                                    //-- Fotografía del local escolar
                                    if(datos.RutaFoto !=null){$('.gen_rutaFoto').append('<div class="row name_educativo"><div class="col-xs-12 text-center"><h3 class="general_content_name text-center" style="margin-bottom:10px">Fotografía del Local Escolar</h3><img src="http://jc.pe/portafolio/cie/cap3/'+datos.RutaFoto+'" class="foto_img" /></div></div>');}else{$('.gen_rutaFoto').append('');}
                                    
                                    //Infraestructura
                                    //--Numero de predios y edificaciones
                                    if( datos.cPred == 0){ $('.inf_numPredios').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_numPredios').append(datos.cPred);}
                                    if( datos.cEdif== 0){ $('.inf_numEdificaciones').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_numEdificaciones').append(datos.cEdif);}
                                    if( (datos.Piso ==null) || (datos.Piso== 0)){ $('.inf_countPiso').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_countPiso').append(datos.Piso); }
                                    if( datos.P1_B_3_9_At_Local== null){ $('.inf_areTerreno').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_areTerreno').append(datos.P1_B_3_9_At_Local+" m2");}                                    
                                    //--Otras edificaciones
                                    if( datos.P== 0){ $('.inf_numPatios').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_numPatios').append(datos.P);}
                                    if( datos.LD== 0){ $('.inf_numLosDeportivas').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_numLosDeportivas').append(datos.LD);}
                                    if( datos.CTE== 0){ $('.inf_numCisTanques').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_numCisTanques').append(datos.CTE);}
                                    if( datos.MC== 0){$('.inf_numMurContencion').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_numMurContencion').append(datos.MC);}
                                    //--Servicios basicos y comunicaciones
                                    if( (datos.P2_C_2LocE_1_Energ== null) || (datos.P2_C_2LocE_1_Energ ==2)){ $('.inf_serBasEnerElec').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{$('.inf_serBasEnerElec').append('<img src="<?php echo base_url()?>assets/img/icono/success.png "/>'); }
                                    if( (datos.P2_C_2LocE_2_Agua== null) || (datos.P2_C_2LocE_2_Agua ==2)){$('.inf_aguPtable').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_aguPtable').append('<img src="<?php echo base_url()?>assets/img/icono/success.png "/>');}
                                    if( (datos.P2_C_2LocE_3_Alc== null) || (datos.P2_C_2LocE_3_Alc ==2)){ $('.inf_alcantarillado').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_alcantarillado').append('<img src="<?php echo base_url()?>assets/img/icono/success.png "/>');}
                                    if( (datos.P2_C_2LocE_4_Tfija== null) || (datos.P2_C_2LocE_4_Tfija ==2)){ $('.inf_telFija').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_telFija').append('<img src="<?php echo base_url()?>assets/img/icono/success.png "/>');}
                                    if( (datos.P2_C_2LocE_5_Tmov== null) || (datos.P2_C_2LocE_5_Tmov ==2)){$('.inf_telMovil').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_telMovil').append('<img src="<?php echo base_url()?>assets/img/icono/success.png "/>');}
                                    if( (datos.P2_C_2LocE_6_Int== null) || (datos.P2_C_2LocE_6_Int ==2)){$('.inf_internet').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>'); }else{ $('.inf_internet').append('<img src="<?php echo base_url()?>assets/img/icono/success.png "/>');}
                                    //--Espacios educativos que funcionan en las edificaciones
                                    if( datos.e_1== 0){ $('.inf_aulComun').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_aulComun').append(datos.e_1);}
                                    if( datos.e_2== 0){ $('.inf_pedagogico').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_pedagogico').append(datos.e_2);}
                                    if( datos.e_3== 0){ $('.inf_administrativo').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_administrativo').append(datos.e_3);}
                                    if( datos.e_4== 0){ $('.inf_complementario').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_complementario').append(datos.e_4);}
                                    if( datos.e_5== 0){ $('.inf_servicio').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_servicio').append(datos.e_5);}
                                    //--Características de las edificaciones
                                    if( datos.eo_1== 0){ $('.inf_gobNacional').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_gobNacional').append(datos.eo_1);}
                                    if( datos.eo_2== 0){ $('.inf_gobLocal').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_gobLocal').append(datos.eo_2);}
                                    if( datos.eo_3== 0){ $('.inf_apafa').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{$('.inf_apafa').append(datos.eo_3); }
                                    if( datos.a_1== 0){ $('.inf_antes').append('<img src="<?php echo base_url()?>assets/img/icono/cancel.png "/>');}else{ $('.inf_antes').append(datos.a_1);}
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
                                                        '<div class="col-xs-12 h3_footer">'+
                                                            '<h3 class=" col-xs-9 general_content_name_general text-center">Principales características del local escolar código del local escolar n° <span class="gen_codLocal"></span></h3>' +
                                                            '<a href="" class="col-xs-3 btn btn-success btn-sm descar_info_general btnDonwload" id=""  style="padding: 5px;"><div class="col-xs-2" style="padding: 0;"><i class="glyphicon glyphicon-download-alt"></i></div>  <div class="col-xs-10" style="padding: 0">Descargar <br>información</div></a>' +
                                                        '</div>'+
                                                        '<div class="col-xs-12 h3_footer">'+
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
                                                                                    '<td width="70%">Latitud <strong style="margin-right:20px"><span class="gen_latitud"></span></strong> Longitud <strong style="margin-right:20px"><span class="gen_longitud"></span></strong> Altitud <strong><span class="gen_altitud"></span></strong></td>' +
                                                                                '</tr>' +
                                                                            '</table>' +
                                                                        '</div>' +
                                                                    '</div>' +
                                                                '</div>' +
                                                            '</div>'+
                                                        '</div>'+
                                                        
                                                        '<div class="col-xs-12 h3_footer">'+
                                                            '<div class="gen_rutaFoto"></div>'+
                                                        '</div>'+
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        
                                        '<div id="tab2" class="tab_content" style="display:none;">' +
                                            '<div class="col-xs-12">' +
                                                '<div class="infraestructura">' +
                                                    '<div class="col-xs-12 h3_footer"  style="margin-left: -4px;">'+
                                                            '<h3 class=" col-xs-9 general_content_name_general text-center">Principales características del local escolar código del local escolar n° <span class="gen_codLocal"></span></h3>' +
                                                            '<a href="" class="col-xs-3 btn btn-success btn-sm descar_info_general btnDonwload" id=""  style="padding: 5px;"><div class="col-xs-2" style="padding: 0;"><i class="glyphicon glyphicon-download-alt"></i></div>  <div class="col-xs-10" style="padding: 0">Descargar <br>información</div></a>' +
                                                        '</div>'+
                                                
                                                
                                                    '<div class="row infra_content">' +
                                                        '<div class="col-xs-6 h3_footer">' +
                                                            
                                                            '<div class="col-xs-12 quitar_izquierda">' +
                                                                '<h3 class="infra_content_name">Número predios y edificaciones</h3>' +
                                                                '<div class="content_infra">' +
                                                                    '<table class="table content_infra_table">'+
                                                                        '<tr>'+
                                                                            '<td width="60%">Predios</td>'+
                                                                            '<td width="40%" class="text-center"><strong><span class="inf_numPredios"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>'+
                                                                            '<td width="60%">Edificaciones</td>'+
                                                                            '<td width="40%" class="text-center"><strong><span class="inf_numEdificaciones"></span></strong></td>'+
                                                                        '</tr>'+
                                                                        '<tr>' +
                                                                            '<td width="60%">Total de pisos</td>' +
                                                                            '<td width="40%" class="text-center"><strong><span class="inf_countPiso"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="60%">Área del terreno</td>' +
                                                                            '<td width="40%" class="text-center" style="text-transform: lowercase;"><strong><span class="inf_areTerreno"></span></strong></td>' +
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
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_numPatios"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Losa deportiva</td>' +
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_numLosDeportivas"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Cisterna - tanque</td>' +
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_numCisTanques"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Muro de contención</td>' +
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_numMurContencion"></span></strong></td>' +
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
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_aulComun"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Pedagógico</td>' +
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_pedagogico"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Administrativo</td>' +
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_administrativo"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Complementario</td>' +
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_complementario"></span></strong></td>' +
                                                                        '</tr>' +
                                                                        '<tr>' +
                                                                            '<td width="90%">Servicios</td>' +
                                                                            '<td width="10%" class="text-center"><strong><span class="inf_servicio"></span></strong></td>' +
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
                                                                                        '<td width="90%">Gobierno Nacional / Proyecto Especial</td>' +
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_gobNacional"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Gobierno Regional / Local</td>' +
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_gobLocal"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Apafa / Autoconstrucción</td>' +
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_apafa"></span></strong></td>' +
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
                                                                                        '<td width="90%">Antes y durante 1977</td>' +
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_antes"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Entre 1978 y 1998</td>' +
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_entre"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Después de 1998</td>' +
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_despues"></span></strong></td>' +
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
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_countEdiMante"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Número de edificaciones para reforzamiento estructural</td>' +
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_countEdiEstruc"></span></strong></td>' +
                                                                                    '</tr>' +
                                                                                    '<tr>' +
                                                                                        '<td width="90%">Número de edificaciones para demolición</td>' +
                                                                                        '<td width="10%" class="text-center"><strong><span class="inf_countEdiDemo"></span></strong></td>'+
                                                                                    '</tr>'+
                                                                                '</table>'+
                                                                            '</div>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</div>' +
                                                            
                                                        '</div>' +
//                                                        '<div class="col-xs-12 h3_footer" >' +
//                                                            '<h3 class="infra_content_name text-center" style="border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px;">Fuente instituto nacional de estadística e informatica - Censo e infraestructura educativa 2013</h3>' +
//                                                        '</div>' +
                                                   '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        
                                        '<div id="tab4" class="tab_content" style="display:none;">' +
                                            '<div class="col-xs-12 ">'+
                                                '<h3 class=" col-xs-9 general_content_name_general text-center">Principales características del local escolar código del local escolar n° <span class="gen_codLocal"></span></h3>' +
                                                '<a href="" class="col-xs-3 btn btn-success btn-sm descar_info_general btnDonwload" id=""  style="padding: 5px;"><div class="col-xs-2" style="padding: 0;"><i class="glyphicon glyphicon-download-alt"></i></div>  <div class="col-xs-10" style="padding: 0">Descargar <br>información</div></a>' +
                                            '</div>'+
                                            '<div class="col-xs-12 text-center">'+
                                                
                                                '<h3 class="general_content_name text-center" style="margin-bottom: 10px;border-radius: 0;">REGISTRO FOTOGRÁFICO</h3>'+
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
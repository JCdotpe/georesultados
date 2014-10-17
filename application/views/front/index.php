<div id="header" class="container-fluid header_maps">
    <a class="logo" href="#">
        <img class="header_maps_img" src="<?php echo base_url() ?>assets/img/logo-inei.png" />
    </a>
    <div class="titulo_head">
        <span>Censo de Infraestructura Educativa 2013</span>
    </div>
    <div class="oted">
        <!--<span>Oficina Técnica de Estadísticas Departamentales - OTED</span>-->
    </div>
</div>
<!-- Cuerpo -->
<div id="cuerpo" >
    <div id="msg" class="text-center"></div>

    <div class="row ">
        <div class="filtro_map">
            <div class="row">
                <div class="col-xs-12">
                    <div class="filtro_map_datos">

                        <!-- Tipo -->
                        <div id="dv_searchTipo" class="form-group col-xs-12 text-center" style="margin-bottom: -6px;border-bottom: 1px solid #ccc;">
                            <label class="preguntas_sub2" for="searchCodigo">Tipo de búsqueda por:</label>
                            <div class="form-group"  style="margin-bottom: 0px;font-size: 13px;">
                                <div class="radio"  style="margin-top: 0px;">
                                    <label><input type="radio" name="optTipoBusqueda" id="optCodigo" value="cod">Código de local</label>
                                </div>
                                <div class="radio" style="margin-top: 0px;">
                                    <label><input type="radio" name="optTipoBusqueda" id="optColegio" value="col">Nombre de la Institución Educativa</label>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Tipo -->

                        <!-- Buscador codigo -->
                        <div id="dv_searchParent" class="form-group col-xs-12 text-center"  style="margin-bottom: 0;">
                            <label class="preguntas_sub2" for="searchCodigo">Código de local</label>
                            <div class="form-group col-xs-12 h3_footer">
                                <input type="text" name="searchCodigo" class="col-xs-9 form-control input-sm text-center" maxlength="6" id="searchCodigo" placeholder="Código de local" onKeyPress="return validar(event);"/>
                            </div>
                        </div>
                        <!-- Fin Buscador codigo -->


                        <!-- Buscador Colegio -->
                        <div id='div-colegio'>


                            <div id="dv_searchColegio" class="form-group col-xs-12 topSearchColegio"  style="margin-bottom: 0;padding-top: 8px;">
                                <label class="preguntas_sub2" for="searchColegio">Nombre de la Institución Educativa </label>
                                <div class="form-group  col-xs-12 h3_footer">
                                    <input type="text" name="searchColegio" class="col-xs-9 form-control input-sm search " id="searchColegio" placeholder="Nombre de la Institución Educativa" />
                                </div>
                            </div>
                            <!-- Fin Buscador Colegio -->

                            <!-- Departamento -->
                            <div id="dv_dep" class="form-group col-xs-12 text-center coger_valor">
                                <label class="preguntas_sub2" for="depa">departamento</label>
                                <select id="depa" class="col-xs-12 sinpadding select2" name="depa">
                                    <option value="">Seleccione</option>
                                    <!-- cargando departamentos -->
                                </select>
                            </div>
                            <!-- Fin Departamento -->

                            <!-- Provincia -->
                            <div id="dv_prov" class="form-group col-xs-12 text-center coger_valor">
                                <label class="preguntas_sub2" for="prov">provincia</label>
                                <div class="controls">
                                    <select id="prov" class="col-xs-12 sinpadding select2" name="prov">
                                        <option  value="">Seleccione</option>
                                        <!-- cargando provincias -->
                                    </select>
                                </div>
                            </div>
                            <!-- fin provincia-->

                            <!-- Distrito -->
                            <div id="dv_dist" class="form-group col-xs-12 text-center coger_valor">
                                <label class="preguntas_sub2" for="dist">distrito</label>
                                <select id="dist" class="col-xs-12 sinpadding select2" name="dist">
                                    <option  value="">Seleccione</option>
                                    <!-- cargando distritos -->
                                </select>
                            </div>
                            <!-- Fin Distrito -->
                        </div>
                        <a rel="facebox" href="" class="mihref"></a>
                        <!-- botones de envio -->
                        <div id="boton_accion" class="form-group col-xs-12 text-center clase_boton_accion">
<!--                            <div class="col-xs-6">-->
                                <button name="sendSearch" id="filtrar" class="btn btn-success" onclick="filtrarTablaLista('<?php echo base_url(); ?>', 'buscarDatosLocal', 1)" type="button" >Buscar</button>
<!--                            </div>-->
<!--                            <div class="col-xs-6">
                                <button id="limpiar_inputs" class="btn btn-danger " name="sendSearch" >Limpiar</button>
                            </div>-->
                        </div>
                        <!-- Fin botones de envio -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="map_container">
        <div id="map-canvas"></div>
    </div>
</div>
<!-- Fin Cuerpo -->
<script type="text/javascript">
    $(function() {
        $("#dv_searchParent").hide();
        $("#div-colegio").hide();
        $("#boton_accion").hide();
        $('.mihref').attr('href','');

        $("#optCodigo").on("click", function() {

            $(".mihref").removeAttr('href');
            $("#div-colegio").hide();
            $("#dv_searchParent").show();
            $("#searchCodigo").val("");
            $("#searchColegio").val("");

            $("#boton_accion").show();
            $('#prov').empty();
            $('#dist').empty();
            $("#prov").append('<option value="">Seleccione</option>');
            $("#dist").append('<option value="">Seleccione</option>');
            $("#dv_dep .select2-chosen").text("Seleccione");
            $('#depa').prop('selectedIndex', 0);
            $("#depa").val("");
            $("#dv_prov .select2-chosen").text("Seleccione");
            $("#dv_dist .select2-chosen").text("Seleccione");
        });

        $("#optColegio").on("click", function() {

            $(".mihref").removeAttr('href');
            $("#dv_searchParent").hide();
            $("#div-colegio").show();
            $("#searchCodigo").val("");
            $("#searchColegio").val("");
            $("#boton_accion").show();
        });


//        $("#searchCodigo").on("click", function() {
//            $(this).select();
//            $("#searchColegio").val("");
//            $('#prov').empty();
//            $('#dist').empty();
//            $("#prov").append('<option value="">Seleccione</option>');
//            $("#dist").append('<option value="">Seleccione</option>');
//            $("#dv_dep .select2-chosen").text("Seleccione");
//            $('#depa').prop('selectedIndex', 0);
//            $("#depa").val("");
//            $("#dv_prov .select2-chosen").text("Seleccione");
//            $("#dv_dist .select2-chosen").text("Seleccione");
//            $("#depa").attr("disabled", true);
//            $("#prov").attr("disabled", true);
//            $("#dist").attr("disabled", true);
//        });
//
//        $("#searchColegio").on("click", function() {
//            $(this).select();
//            $("#searchCodigo").val("");
//            $('#prov').empty();
//            $('#dist').empty();
//            $("#prov").append('<option value="">Seleccione</option>');
//            $("#dist").append('<option value="">Seleccione</option>');
//            $("#dv_dep .select2-chosen").text("Seleccione");
//            $('#depa').prop('selectedIndex', 0);
//            $("#depa").val("");
//            $("#dv_prov .select2-chosen").text("Seleccione");
//            $("#dv_dist .select2-chosen").text("Seleccione");
//            $("#depa").attr("disabled", false);
//            $("#prov").attr("disabled", false);
//            $("#dist").attr("disabled", false);
//        });

//        $("#limpiar_inputs").on("click", function() {
//            $("#searchColegio").val("");
//            $("#searchCodigo").val("");
//            $('#prov').empty();
//            $('#dist').empty();
//            $("#prov").append('<option value="">Seleccione</option>');
//            $("#dist").append('<option value="">Seleccione</option>');
//            $("#dv_dep .select2-chosen").text("Seleccione");
//            $('#depa').prop('selectedIndex', 0);
//            $("#depa").val("");
//            $("#dv_prov .select2-chosen").text("Seleccione");
//            $("#dv_dist .select2-chosen").text("Seleccione");
//            $("#depa").attr("disabled", false);
//            $("#prov").attr("disabled", false);
//            $("#dist").attr("disabled", false);
//            $("#searchCodigo").focus();
//        });
    });
</script>

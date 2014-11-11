<div id="header" class="container-fluid header_maps">
    <a class="logo" href="#">
        <img class="header_maps_img" src="<?php echo base_url() ?>assets/img/logo-inei.png" />
    </a>
    <div class="titulo_head">
        <span>Censo de Infraestructura Educativa 2013</span>
    </div>
    <div class="oted">
    </div>
</div>
<div id="cuerpo" >
    <div id="msg" class="text-center"></div>
    <div class="row ">
        <div class="filtro_map">
            <div class="row">
                <div class="col-xs-12">
                    <div class="filtro_map_datos">
                        <div id="dv_searchTipo" class="form-group col-xs-12 div_searchTipo">
                            <label class="preguntas_sub2" for="searchCodigo">Tipo de búsqueda por:</label>
                            <div class="form-group orderRadioButton">
                                <div class="radio"  style="margin-top: 0px;">
                                    <label><input type="radio" name="optTipoBusqueda" id="optCodigo" value="cod">Código de local</label>
                                </div>
                                <div class="radio" style="margin-top: 0px;">
                                    <label><input type="radio" name="optTipoBusqueda" id="optColegio" value="col">Nombre de la Institución Educativa</label>
                                </div>
                            </div>
                        </div>
                        <div id="dv_searchParent" class="form-group col-xs-12"  style="margin-bottom: 0;padding-top: 15px;">
                            <label class="preguntas_sub2 text-center" for="searchCodigo">Código de local</label>
                            <div class="form-group col-xs-12 h3_footer">
                                <input type="text" name="searchCodigo" class="col-xs-9 form-control input-sm " maxlength="6" id="searchCodigo" placeholder="Código de local" onKeyPress="return validar(event);"/>
                            </div>
                        </div>
                        <div id='div-colegio'>
                            <div id="dv_searchColegio" class="form-group col-xs-12 topSearchColegio"  style="margin-bottom: 0;padding-top: 8px;">
                                <label class="preguntas_sub2" for="searchColegio">Nombre de la Institución Educativa </label>
                                <div class="form-group  col-xs-12 h3_footer">
                                    <input type="text" name="searchColegio" class="col-xs-9 form-control input-sm search " id="searchColegio" placeholder="Nombre de la Institución Educativa" />
                                </div>
                            </div>
                            <div id="dv_dep" class="form-group col-xs-12  coger_valor">
                                <label class="preguntas_sub2" for="depa">departamento</label>
                                <select id="depa" class="col-xs-12 sinpadding select2" name="depa">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                            <div id="dv_prov" class="form-group col-xs-12 coger_valor">
                                <label class="preguntas_sub2" for="prov">provincia</label>
                                <div class="controls">
                                    <select id="prov" class="col-xs-12 sinpadding select2" name="prov">
                                        <option  value="">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div id="dv_dist" class="form-group col-xs-12  coger_valor">
                                <label class="preguntas_sub2" for="dist">distrito</label>
                                <select id="dist" class="col-xs-12 sinpadding select2" name="dist">
                                    <option  value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <a rel="facebox" href="" class="mihref"></a>
                        <div id="boton_accion" class="form-group col-xs-12 clase_boton_accion">
                            <button name="sendSearch" id="filtrar" class="col-xs-12 btn btn-success" onclick="filtrarTablaLista('<?php echo base_url(); ?>', 'buscarDatosLocal', 1)" type="button" ><i class="fa fa-search"></i> Buscar</button>
                        </div>
                        <div id="download_general_archive">
                            <hr>
                            <div class="form-group col-xs-12 h3_footer">
                                <label style="padding-left: 17px;"> Documentos de Consulta</label>
                            </div>
                            <div class="form-group col-xs-12 h3_footer">
                                <a href="<?php echo base_url()?>assets/public/download/censo_de_insfraestructura_educativa_2013.pdf" class="download_href" target="_blank" download="censo_de_insfraestructura_educativa_2013.pdf">
                                    <div class="col-xs-2" style="padding-top: 10px;">
                                        <img class="" src="<?php echo base_url()?>assets/img/pdf_new.png" width="30" />
                                    </div>
                                    <div class="col-xs-10">
                                        <span style="font-size: 13px;">Glosario de términos del Censo de Infraestructura Educativa 2013</span>
                                    </div>
                                </a>
                            </div>
                            <div class="form-group col-xs-12 h3_footer">
                                <a href="<?php echo base_url()?>assets/public/download/nivel_de_intervencion_censo_de_insfraestructura_educativa_2013.pptx" target="_blank" class="download_href" download="nivel_de_intervencion_censo_de_insfraestructura_educativa_2013.pptx">
                                    <div class="col-xs-2" style="padding-top: 16px;">
                                        <img class="" src="<?php echo base_url()?>assets/img/ppt_new.png"  width="30"/>
                                    </div>
                                    <div class="col-xs-10">
                                        <span style="font-size: 13px;">Flujograma resumen del Nivel de intervención Censo de Infraestructura Educativa 2013</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="map_container">
        <div id="map-canvas"></div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("#dv_searchParent").hide();
        $("#div-colegio").hide();
        $("#boton_accion").hide();
        $("#download_general_archive").hide();
        $('.mihref').attr('href', '');

        $("#optCodigo").on("click", function() {
            $(".mihref").removeAttr('href');
            $("#div-colegio").hide();
            $("#dv_searchParent").show();
            $("#searchCodigo").val("");
            $("#searchColegio").val("");
            $("#boton_accion").show();
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
        });

        $("#optColegio").on("click", function() {
            $(".mihref").removeAttr('href');
            $("#dv_searchParent").hide();
            $("#div-colegio").show();
            $("#searchCodigo").val("");
            $("#searchColegio").val("");
            $("#boton_accion").show();
            $("#download_general_archive").show();
            $("#searchColegio").focus();
        });
    });
</script>

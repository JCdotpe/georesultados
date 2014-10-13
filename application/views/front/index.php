<div id="header" class="container-fluid header_maps">
    <a class="logo" href="#">
        <img class="header_maps_img" src="<?php echo base_url() ?>assets/img/logo-inei.png" />
    </a>
    <div class="titulo">
        <span>Censo de Infraestructura Educativa 2013</span>
    </div>
    <div class="oted">
        <!--<span>Oficina Técnica de Estadísticas Departamentales - OTED</span>-->
    </div>	
</div>
<!-- Cuerpo -->
<div id="cuerpo" >
    <div id="msg"></div>
    <div class="map_container">
        <div id="map-canvas"></div>
    </div>
    <div class="row ">


        <div class="filtro_map">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Buscador codigo -->
                    <div id="dv_search">
                        <div id="dv_searchParent" class="form-group col-xs-12 text-center"  style="margin-bottom: 0;">
                            <label class="preguntas_sub2" for="searchCodigo">Nombre de la Institución Educativa</label>
                            <div class="form-group col-xs-12 h3_footer">
                                <input type="text" name="searchCodigo" class="col-xs-9 form-control input-sm text-center" maxlength="6" id="searchCodigo" placeholder="Buscar por código" onKeyPress="return validar(event);"/>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Buscador codigo -->

                    <!-- Buscador Colegio -->
                    <div id="dv_searchColegio" class="form-group col-xs-12 text-center"  style="margin-bottom: 0;">
                        <label class="preguntas_sub2" for="searchColegio">Código de local </label>
                        <div class="form-group contentArea col-xs-12 h3_footer">
                            <input type="text" name="searchColegio" class="col-xs-9 form-control input-sm search searchColegio" id="searchColegio" placeholder="Ingrese nombre I.E"/>
                        </div>
                    </div>
                    <!-- Fin Buscador Colegio -->

                    <!-- Departamento -->
                    <div id="dv_dep" class="form-group col-xs-12 text-center">
                        <label class="preguntas_sub2" for="depa">departamento</label>
                        <select id="depa" class="col-xs-12 sinpadding select2" name="depa">
                            <option value="">Seleccione</option>
                            <option value="-1">TODOS</option>
                            <!-- cargando departamentos -->
                        </select>
                    </div>
                    <!-- Fin Departamento -->

                    <!-- Provincia -->
                    <div id="dv_prov" class="form-group col-xs-12 text-center">
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
                    <div id="dv_dist" class="form-group col-xs-12 text-center">
                        <label class="preguntas_sub2" for="dist">distrito</label>
                        <select id="dist" class="col-xs-12 sinpadding select2" name="dist">
                            <option  value="">Seleccione</option>
                            <!-- cargando distritos -->
                        </select>                            
                    </div>
                    <!-- Fin Distrito -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Cuerpo -->

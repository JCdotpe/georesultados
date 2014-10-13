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
    <div class="filtro_map">
        <div class="row">
            <div class="col-xs-12">
                <!-- Buscador Tipo -->
                <div id="dv_searchTipo" class="form-group col-xs-12 text-center" style="margin-bottom: -6px;">
                    <label class="preguntas_sub2" >Tipo de búsqueda:</label>
                    <div class="form-group text-left" style="margin-bottom: 0px;">
                        <div class="radio"  style="margin-top: 0px;">
                            <label><input type="radio" name="optTipoBusqueda" id="optCodigo" value="cod">Por código de local escolar</label>
                        </div>
                        <div class="radio" style="margin-top: 0px;">
                            <label><input type="radio" name="optTipoBusqueda" id="optColegio" value="col">Por nombre de I.E <i class="glyphicon glyphicon-question-sign tooltip_info" data-toggle="tooltip" data-placement="right" title="" data-original-title="Institución Educativa"></i></label>
                        </div>
                    </div>
                </div>
                <!-- Fin Buscador Tipo-->
                
                <!-- Buscador codigo -->
                <div id="dv_search">
                    <div id="dv_searchParent" class="form-group col-xs-12 text-center"  style="margin-bottom: 0;">
                        <label class="preguntas_sub2" for="searchCodigo">Buscar por código</label>
                        <div class="form-group col-xs-12 h3_footer">
                            <input type="text" name="searchCodigo" class="col-xs-9 form-control input-sm text-center" maxlength="6" id="searchCodigo" placeholder="Buscar por código" onKeyPress="return validar(event);" style="width: 142px;margin-right: 6px;"/>
                            <button type="submit" class="col-xs-3 btn btn-primary btn-sm" id="btnFindCodLocal" name="btnFindCodLocal"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </div>
                <!-- Fin Buscador codigo -->

                <!-- Buscador Colegio -->
                <div id="dv_searchColegio" class="form-group col-xs-12 text-center"  style="margin-bottom: 0;">
                    <label class="preguntas_sub2" for="searchColegio">Ingrese nombre I.E <i class="glyphicon glyphicon-question-sign tooltip_info" data-toggle="tooltip" data-placement="left" title="" data-original-title="Ingrese nombre Institución Educativa"></i></label>
                    <div class="form-group contentArea col-xs-12 h3_footer">
                        <input type="text" name="searchColegio" class="col-xs-9 form-control input-sm search searchColegio" id="searchColegio" placeholder="Ingrese nombre I.E"  style="width: 142px;margin-right: 6px;"/>
                        <button type="submit" class="col-xs-3 btn btn-primary btn-sm" id="btnFindColegio" name="btnFindCodLocal" style="width: 50px"><i class="glyphicon glyphicon-search" ></i></button>
                        <div class="hiddenColegioCodigo" style="display: none"></div>
                        <div id="divResult"></div>
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
<!-- Fin Cuerpo -->

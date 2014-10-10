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
                <!-- Buscador -->
                <div id="dv_search" class="form-group col-xs-12 text-center">
                    <label class="preguntas_sub2" for="searchCodigo">Buscar por código</label>

                    <div class="form-group">
                        <input type="text" name="searchCodigo" class="col-xs-9 form-control input-sm text-center" maxlength="6" id="searchCodigo" placeholder="Buscar por código" onKeyPress="return validar(event);" style="width: 120px;margin-right: 6px;"/>
                        <button type="submit" class="col-xs-3 btn btn-primary btn-sm" id="btnFindCodLocal" name="btnFindCodLocal"><i class="glyphicon glyphicon-search"></i></button>
                    </div>

                </div>
                <!-- Fin Buscador -->
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
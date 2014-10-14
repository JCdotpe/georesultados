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
                    <form role="form" action="<?php echo base_url() ?>buscarDatosLocal" class="form" id="" method="post">

                        <!-- Buscador Colegio -->
                        <div id="dv_searchColegio" class="form-group col-xs-12 topSearchColegio"  style="margin-bottom: 0;">
                            <label class="preguntas_sub2" for="searchColegio">Nombre de la Institución Educativa </label>
                            <div class="form-group  col-xs-12 h3_footer">
                                <input type="text" name="searchColegio" class="col-xs-9 form-control input-sm search " id="searchColegio" placeholder="Nombre de la Institución Educativa" />
                            </div>
                        </div>
                        <!-- Fin Buscador Colegio -->

                        <!-- Buscador codigo -->
                        <div id="dv_searchParent" class="form-group col-xs-12 text-center"  style="margin-bottom: 0;">
                            <label class="preguntas_sub2" for="searchCodigo">Código de local</label>
                            <div class="form-group col-xs-12 h3_footer">
                                <input type="text" name="searchCodigo" class="col-xs-9 form-control input-sm text-center" maxlength="6" id="searchCodigo" placeholder="Código de local" onKeyPress="return validar(event);"/>
                            </div>
                        </div>
                        <!-- Fin Buscador codigo -->                    

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

                        <!-- botones de envio -->
                        <div id="boton_accion" class="form-group col-xs-12 text-center clase_boton_accion">
                            <div class="col-xs-6">
                                <input type="submit" class="btn btn-success " name="sendSearch" value="Buscar" />
                            </div>
                            <div class="col-xs-6">
                                <input type="reset" class="btn btn-danger " name="sendSearch" value="Limpiar" />
                            </div>
                        </div>
                        <!-- Fin botones de envio -->
                    </form>
                </div>

            </div>

            <!-- Button trigger modal -->
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                Modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            Aenean placerat arcu sapien, a tempor nulla ultrices nec. 
                            Curabitur diam ex, porttitor non eros eu, molestie pretium tortor. 
                            Cras a lorem a metus ullamcorper semper sit amet ac sem. 
                            Cras dignissim risus id mattis placerat. 
                            Fusce eleifend nunc leo, at dignissim nisi vehicula eu. 
                            Donec porttitor tincidunt 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- Fin Cuerpo -->

<?php
$filtroBusqueda = "&searchColegio=" . $_REQUEST['searchColegio'] . "&searchCodigo=" . $_REQUEST['searchCodigo'] . "&depa=" . $_REQUEST['depa'] . "&prov=" . $_REQUEST['prov'] . "&dist=" . $_REQUEST['dist'];
?>
<div class="titulo">Censo de Infraestructura Educativa 2013 - Resultados de los datos filtrados <?php if (count($datos_Resumen) > 0) { ?> <a href="<?php echo base_url() ?>exportar/csvexport/por_ubigeo?envio=1<?php echo $filtroBusqueda; ?>" class="fileDownload-data" id="download_filtro_datos" ><i  class="fa fa-download"></i> Exportar Resultados</a><?php
    } else {
        echo "";
    }
    ?>
</div>
<div class="cuerpo">
    <?php
    if (count($datos_Resumen) > 0) {
        ?>
        <label class="text-muted">Podrá ver el detalle del filtro haciendo clic en este simbolo <i class="fa fa-map-marker text-primary"></i> que se encuentra al costado del número de "Código del Local Escolar"</label>
        <table class="table table-striped table-hover title_center_table">
            <thead>
                <tr class="text-uppercase">
                    <th class="text-center" style="width: 80px;">Código del Local Escolar</th>
                    <th class="text-center">Nombre de la Institución Educativa</th>
                    <th class="text-center">Nivel Educativo</th>
                    <th class="text-center" style="width: 100px;">Propietario del predio</th>
                    <th class="text-center">Nombre del Director</th>
                    <th class="text-center">Dirección</th>
                    <th class="text-center">Departamento / Provincia / Distrito</th>
                    <th class="text-center">Total de Alumnos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos_Resumen as $datoResumen) { ?>
                    <tr>
                        <td class="text-center"><a href="javascript:;" class="details_eyes  close_image" onclick="llevarMapa('<?php echo $datoResumen['codigo_de_local'] ?>');
                                        jQuery(document).trigger('close.facebox');"><i class="fa fa-map-marker fa-2x floatCodigo"></i> <?php echo $datoResumen['codigo_de_local'] ?></a></td>
                        <td><?php echo $datoResumen['nombres_IIEE'] ?></td>
                        <td ><?php echo $datoResumen['nivel'] ?></td>
                        <td class="text-center"><?php echo $datoResumen['prop_IE'] ?></td>
                        <td><?php echo $datoResumen['Director_IIEE'] ?></td>
                        <td><?php echo $datoResumen['direcc_IE'] ?></td>
                        <td><?php echo $datoResumen['dpto_nombre'] ?> / <?php echo $datoResumen['prov_nombre'] ?> / <?php echo $datoResumen['dist_nombre'] ?></td>
                        <td class="text-center"><?php echo $datoResumen['Talum'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <h3> Local escolar no encontrado...</h3>
    <?php }
    ?>
</div>
<div class="pieFacebox">Total encontrados : <?php echo count($datos_Resumen) ?></div>
<script type="text/javascript">
    $(function() {
        $("#download_filtro_datos").click(function() {
            var url_donwload = $("#download_filtro_datos").attr('href');
            $.ajax({
                url: url_donwload,
                type: 'GET',
                beforeSend: function() {
                    $('#download_filtro_datos').addClass("span_a_download");
                    $('#download_filtro_datos').html("<i id='change_carga' class='fa fa-spinner fa-spin fa-2x'></i> Exportando Resultados");
                },
                success: function(data) {
                    if (data) {
                        $('#download_filtro_datos').removeClass("span_a_download");
                        $('#download_filtro_datos').html("<i id='change_carga' class='fa fa-download'></i> Exportar Resultados");
                    }
                }
            });
        });
    });

    function llevarMapa(local_id) {
        var num_local_id = local_id;
        var url = "<?php echo base_url() ?>home/getBubble?idCodigo=" + num_local_id;
        $.get(url, function(data) {
            $("#btnDonwload").attr("href", "<?php echo base_url() ?>exportar/csvexport/por_Codigo?idCodigo=" + num_local_id);
            var result = JSON.parse(data);
            $.each(result, function(i, datos) {
                var latitud = datos.LatitudPunto_UltP;
                var longitud = datos.LongitudPunto_UltP;
                var puntokml = datos.cod_dpto + datos.cod_prov + datos.cod_dist;
                load_kml_ft(table_dist, puntokml);
                zomCenter = new google.maps.LatLng(latitud, longitud);
                zom = 8;
                map.setCenter(zomCenter);
                map.setZoom(zom);
            });
            var query = " id_local = '" + num_local_id + "' ";
            load_fusiontable(query);
        });
    }
</script>
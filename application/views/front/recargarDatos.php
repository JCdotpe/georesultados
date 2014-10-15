<?php
#echo $datosEnviar['searchColegio'];
?>


<div class="titulo">Censo de Infraestructura Educativa 2013 - Resultados de los datos filtrados</div>
<div class="cuerpo">
    <?php
    if (count($datos_Resumen) > 0) {
        ?>
    <label class="text-muted">Podrá ver el detalle del filtro haciendo clic en este simbolo <i class="fa fa-map-marker text-primary"></i> que se encuentra al costado del número de "Código de Local"</label>
        <table class="table table-striped table-hover title_center_table">
            <thead>
                <tr>
    <!--                <th>N°</th>-->
                    <th class="text-center">Código del local</th>
                    <th class="text-center">Nombre de la I.E</th>
                    <th class="text-center">Nivel Educativo</th>
                    <th class="text-center">Propietario del predio</th>
                    <th class="text-center">Director</th>
                    <th class="text-center">Dirección</th>
                    <th class="text-center">Departamento / Provincia / Distrito</th>
                    <th class="text-center">Total Alumnos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($datos_Resumen as $datoResumen) {
                    ?>
                    <tr>
        <!--                    <td>1</td>-->
                        <td class="text-center"><a href="javascript:;" class="details_eyes" onclick="llevarMapa('<?php echo $datoResumen['codigo_de_local'] ?>');$(document).trigger('close.facebox');"><i class="fa fa-map-marker"></i> <?php echo $datoResumen['codigo_de_local'] ?></a></td>
                        <td><?php echo $datoResumen['nombres_IIEE'] ?></td>
                        <td><?php echo $datoResumen['nivel'] ?></td>
                        <td><?php echo $datoResumen['prop_IE'] ?></td>
                        <td><?php echo $datoResumen['Director_IIEE'] ?></td>
                        <td><?php echo $datoResumen['direcc_IE'] ?></td>
                        <td><?php echo $datoResumen['dpto_nombre'] ?> / <?php echo $datoResumen['prov_nombre'] ?> / <?php echo $datoResumen['dist_nombre'] ?></td>
                        <td class="text-center"><?php echo $datoResumen['Talum'] ?></td>
                    </tr>
                <?php }
                ?>

            </tbody>
        </table>
    <?php } else { ?>
        <h3> No hay data con el filtro seleccionado</h3>
    <?php }
    ?>
</div>
<div class="pieFacebox">Total encontrados : <?php echo count($datos_Resumen) ?></div>
<script type="text/javascript">
    function llevarMapa(local_id) {
        var num_local_id = local_id;
        var url = "<?php echo base_url() ?>home/getBubble?idCodigo=" + num_local_id;
        $.get(url, function(data) {
            //console.log(data);

            $("#btnDonwload").attr("href", "<?php echo base_url() ?>exportar/csvexport/por_Codigo?idCodigo=" + num_local_id);
            var result = JSON.parse(data);
            $.each(result, function(i, datos) {
                var latitud = datos.LatitudPunto_UltP;
                var longitud = datos.LongitudPunto_UltP;
                var puntokml = datos.cod_dpto + datos.cod_prov + datos.cod_dist;
                //console.log(puntokml);
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


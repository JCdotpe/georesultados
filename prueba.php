<?php ini_set("memory_limit", "-1"); ?>
<html>
    <head>
        <meta charset="utf-8">
        <!-- Enlace a Javascript -->
        <script type="text/javascript" src="assets/js/jquery-1.10.2.js"></script>

    </head>    
    <body>
        <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
            <p>Exportar a Excel  <img src="assets/img/icono/export_to_excel.gif" class="botonExcel" /></p>
            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
        </form>

        <table  class="table table-striped table-hover title_center_table" id="Exportar_a_Excel">
            <thead>
                <tr>
                    <th>RUTA-IMAGEN</th>
                    <th>ANCHO</th>
                    <th>ALTO</th>
                    <th>PESO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$dato = "D:/01";
                $dato = "D:/01";
                leer_archivos_y_directorios($dato);

                function leer_archivos_y_directorios($ruta) {
                    if (is_dir($ruta)) {
                        if ($aux = opendir($ruta)) {
                            while (($archivo = readdir($aux)) !== false) {
                                if ($archivo != "." && $archivo != "..") {
                                    $ruta_completa = $ruta . '/' . $archivo;
                                    if (is_dir($ruta_completa)) {
                                        //echo "<br /><strong>Directorio:</strong> " . $ruta_completa;
                                        leer_archivos_y_directorios($ruta_completa);
                                    } else {
                                        list($width, $height) = getimagesize($ruta_completa);
                                        $tamanio = filesize($ruta_completa);
                                        if ($tamanio >= 1073741824) {
                                            $tamanio_1 = number_format($tamanio / 1073741824, 2) . ' GB';
                                        } elseif ($tamanio >= 1048576) {
                                            $tamanio_1 = number_format($tamanio / 1048576, 2) . ' MB';
                                        } elseif ($tamanio >= 1024) {
                                            $tamanio_1 = number_format($tamanio / 1024, 2) . ' KB';
                                        } elseif ($tamanio > 1) {
                                            $tamanio_1 = $tamanio . ' bytes';
                                        } elseif ($tamanio == 1) {
                                            $tamanio_1 = $tamanio . ' byte';
                                        } else {
                                            $tamanio_1 = '0 bytes';
                                        }



                                        if ($tamanio_1 > "400") {
                                            $back = "background: #e7443c";
                                        } else {
                                            $back = "background: #16a085";
                                        }



                                        echo '<tr>';
                                        echo '<td>' . $ruta_completa . "</td>";
                                        echo '<td>' . $width . "px</td>";
                                        echo '<td>' . $height . "px</td>";
                                        echo '<td style="' . $back . '">' . $tamanio_1 . "</td>";
                                        echo '</tr>';
//                                        $cantidad = $ruta_completa;
//                                        $findme = 'Thumbs.db';
//                                        $pos = strpos($cantidad, $findme);
//                                        if ($pos === false) {
//                                            //echo "La cadena '$findme' no fue encontrada en la cadena '$cantidad'";
//                                        } else {
//                                            //unlink($cantidad);
////                                            echo "La cadena ".$findme." fue encontrada en la cadena ".$cantidad." <br>";
////                                            echo " y existe en la posición ".$pos." <br>";
//                                        }
//                                        if ($pos === false) {
//                                            unlink($ruta_completa);
//                                        }
                                    }
                                }
                            }
                            closedir($aux);
                            //echo "<strong>Fin Directorio:</strong>" . $ruta . "<br /><br />";
                        }
                    } else {
                        //echo $ruta;
                        echo "<br />No es ruta valida";
                    }
                }
                ?>
            </tbody>
        </table>
        <script language="javascript">
            $(document).ready(function() {
                $(".botonExcel").click(function(event) {
                    $("#datos_a_enviar").val($("<div>").append($("#Exportar_a_Excel").eq(0).clone()).html());
                    $("#FormularioExportacion").submit();
                });
            });
        </script>
    </body>
</html>
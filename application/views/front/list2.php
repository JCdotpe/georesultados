<?php

$dato = "C:/CarlosLevano/01";
leer_archivos_y_directorios($dato);

function leer_archivos_y_directorios($ruta) {
    if (is_dir($ruta)) {
        // Abrimos el directorio y comprobamos que
        if ($aux = opendir($ruta)) {
            while (($archivo = readdir($aux)) !== false) {
                // Si quisieramos mostrar todo el contenido del directorio pondríamos lo siguiente:
                //echo '<br />' . $file . '<br />';
                // Pero como lo que queremos es mostrar todos los archivos excepto "." y ".."
                if ($archivo != "." && $archivo != "..") {
                    $ruta_completa = $ruta . '/' . $archivo;

                    // Comprobamos si la ruta más file es un directorio (es decir, que file es
                    // un directorio), y si lo es, decimos que es un directorio y volvemos a
                    // llamar a la función de manera recursiva.
                    if (is_dir($ruta_completa)) {

                        echo "<br /><strong>Directorio:</strong> " . $ruta_completa;
                        leer_archivos_y_directorios($ruta_completa);
                    } else {

                        list($width, $height) = getimagesize($ruta_completa);
                        $tamaño = filesize( $ruta_completa);

                        if ($tamaño >= 1073741824) {
                            $tamaño_1 = number_format($tamaño / 1073741824, 2) . ' GB';
                        } elseif ($tamaño >= 1048576) {
                            $tamaño_1 = number_format($tamaño / 1048576, 2) . ' MB';
                        } elseif ($tamaño >= 1024) {
                            $tamaño_1 = number_format($tamaño / 1024, 2) . ' KB';
                        } elseif ($tamaño > 1) {
                            $tamaño_1 = $tamaño . ' bytes';
                        } elseif ($tamaño == 1) {
                            $tamaño_1 = $tamaño . ' byte';
                        } else {
                            $tamaño_1 = '0 bytes';
                        }

                        echo '<table>';
                        echo '<tr>';
                        echo '<td>' . $archivo . "</td>";
                        echo '<td>' . $width . "px</td>";
                        echo '<td>' . $height . "px</td>";
                        echo '<td>' . $tamaño_1 . "</td>";
                        echo '</tr>';
                        echo '</table>';

//                        echo '<tr>';
//                        echo '<td>' .$archivo . "</td>";
//                        echo '</tr>';
                        //echo '<br />' . $archivo . '<br />';
                    }
                }
            }

            closedir($aux);

            // Tiene que ser ruta y no ruta_completa por la recursividad
            //echo "<strong>Fin Directorio:</strong>" . $ruta . "<br /><br />";
        }
    } else {
        //echo $ruta;
        echo "<br />No es ruta valida";
    }
}

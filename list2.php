<?php

$dato = "C:/CarlosLevano/01/";
leer_archivos_y_directorios($dato);

function leer_archivos_y_directorios($ruta) {
    // comprobamos si lo que nos pasan es un direcotrio
    if (is_dir($ruta)) {
        // Abrimos el directorio y comprobamos que
        if ($aux = opendir($ruta)) {
            while (($archivo = readdir($aux)) !== false) {
                // Si quisieramos mostrar todo el contenido del directorio pondríamos lo siguiente:
                // echo '<br />' . $file . '<br />';
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
                        echo '<br />' . $archivo . '<br />';
                    }
                }
            }
            closedir($aux);
            // Tiene que ser ruta y no ruta_completa por la recursividad
            echo "<strong>Fin Directorio:</strong>" . $ruta . "<br /><br />";
        }
    } else {
        echo $ruta;
        echo "<br />No es ruta valida";
    }
}

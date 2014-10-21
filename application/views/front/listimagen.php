<?php
$path = "C:/CarlosLevano/01/000019/PRED_1/CAP6";
$dir = opendir($path);
$files = array();
while ($current = readdir($dir)) {
    if ($current != "." && $current != "..") {
        if (is_dir($path . $current)) {
            showFiles($path . $current . '/');
        } else {
            $files[] = $current;
        }
    }
}
echo '<h2>' . $path . '</h2>';
?>

<table class="table table-striped table-hover title_center_table">
    <thead>
        <tr>
            <td>RUTA IMAGEN</td>
            <td>ANCHO</td>
            <td>ALTO</td>
            <td>PESO</td>
        </tr>
    </thead>
    <tbody>
        <?php
        for ($i = 0; $i < count($files); $i++) {
            list($width, $height) = getimagesize("C:/CarlosLevano/01/000019/PRED_1/CAP6/" . $files[$i]);
            $tamaño = filesize("C:/CarlosLevano/01/000019/PRED_1/CAP6/" . $files[$i]);

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

            echo '<tr>';
            echo '<td>C:/CarlosLevano/01/000019/PRED_1/CAP6/' . $files[$i] . "</td>";
            echo '<td>' . $width . "px</td>";
            echo '<td>' . $height . "px</td>";
            echo '<td>' . $tamaño_1 . "</td>";
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
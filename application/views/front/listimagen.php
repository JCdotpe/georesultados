<?php

$directory = "C:/CarlosLevano/01/000019/";
$dirint = dir($directory);
while (($archivo = $dirint->read()) !== false) {
    if (eregi("gif", $archivo) || eregi("jpg", $archivo) || eregi("png", $archivo)) {
        echo '<img src="' . $directory . "/" . $archivo . '">' . "\n";
    }
}
$dirint->close();

//$d = dir("/etc/php5");
//echo "Handle: " . $d->handle . "\n";
//echo "Path: " . $d->path . "\n";
//while (false !== ($entry = $d->read())) {
//    echo $entry . "\n";
//}
//$d->close();


?>
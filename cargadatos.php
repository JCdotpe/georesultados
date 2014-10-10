<?php

foreach($array as &$record){
array_map(utf8_encode,$record);
}
json_encode($array);

?>
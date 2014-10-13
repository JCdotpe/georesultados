<?php
$q = $searchwordPost;
foreach ($result_IE as $resulIEE) {
    $username = $resulIEE->nombres_IIEE;
    $b_username = '<b>' . $q . '</b>';
    $final_username = str_ireplace($q, $b_username, $username);
    ?>
    <div class="display_box" align="left">
        <div class="contenido_colegio">
            <span class="name" ><?php echo $final_username; ?></span><br>
            <span class="name_lugar"><strong><?php echo $resulIEE->dpto_nombre; ?></strong> - <strong><?php echo $resulIEE->prov_nombre; ?></strong> - <strong><?php echo $resulIEE->dist_nombre; ?></strong></span>
            <span class="hiddenColegio" style="display: none"><?php echo $resulIEE->codigo_de_local; ?></span>
            <span class="hiddenColegio" style="display: none"><?php echo $resulIEE->codigo_de_local; ?></span>
        </div>
    </div>
    <?php
}
?>

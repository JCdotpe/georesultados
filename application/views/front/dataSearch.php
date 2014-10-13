<?php
$q = $searchwordPost;
foreach ($result_IE as $resulIEE) {
    $username = $resulIEE->nombres_IIEE;
    $b_username = '<b>' . $q . '</b>';
    $final_username = str_ireplace($q, $b_username, $username);
    ?>
    <div class="display_box" align="left">
        <span class="hiddenColegio" style="display: none"><?php echo $resulIEE->codigo_de_local;?></span>
        <span class="name"><?php echo $final_username; ?></span>
    </div>
    <?php
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo (isset($titulo) and $titulo != "") ? $titulo . " | " : ""; ?>INEI</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/maps.css">
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.10.2.js"></script>
    </head>
    <body>
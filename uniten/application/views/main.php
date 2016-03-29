<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="Robots" content="index,follow">
    <meta name="description" content="A missão da UNIT é ampliar as oportunidades da população de Sorocaba e região, promovendo o acesso a cursos de qualificação e requalificação profissional e geração de renda." />
    <meta name="Keywords" content="uniten, unite, unit, universidade, trabalhador, empreendedor, curso, cursos, profissionalizantes, qualificação, requalificação, profissional, geração, renda, diploma, sorocaba">
    <meta name="Author" content="splicenet.com.br">
    <meta name="Copyright" content="splicenet.com.br">
    <meta name="Distribution" content="Global">
    <META Http-Equiv="Cache-Control" Content="no-cache">
    <META Http-Equiv="Pragma" Content="no-cache">
    <META Http-Equiv="Expires" Content="0">
    <title>UNITEN - Universidade do Trabalhador e do Empreendedor de Sorocaba</title>
    <!-- css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/base.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/menu/styles.css')?>" />
    <link href="http://fonts.googleapis.com/css?family=Ubuntu:300,400,700,400italic" rel="stylesheet" type="text/css">
    <!-- js query -->
    <script src="<?php echo base_url('assets/js/jquery-1.9.1.min.js')?>" ></script>
</head>
<body>

<div id="wrapper">
    <div id="top-bar">
        <div class="container clearfix">
            <div id="divContainer">
                <div id="divLogo">
                    <a href="<?php echo base_url('home') ?>"><img src="<?php echo base_url('assets/imgs/logoUniten.png')?>" /></a>
                </div>
                <div id="divLogosPrefeitura"><img src="<?php echo base_url('assets/imgs/logoSEDET-Prefeitura.png')?>" /></div>
                <div id="divSlideTop"><?php  include 'application/includes/slideTop.php'; ?></div>
            </div>
        </div>
    </div>
    <div id="divMenu"><?php include 'application/includes/menu.php'; ?></div>
    <?php //if ($pagina == "home") { //include 'includes/slideHome.php'; } ?>
    <?php if($this->uri->segment(1)=='home' || $this->uri->segment(1)=='' )  include "application/includes/slideHome.php";  ?>

    <div id="divContainer2">
        <!-- CONTEÚDO -->
        <?php echo $content_for_layout?>
       <!-- FIM CONTEÚDO -->
    </div>
    <?php  include 'application/includes/rodape.php'; ?>
</div><!-- /#wrapper -->

<!-- js defer -->
<script src="<?php echo base_url('assets/js/modernizr.custom.js')?>" defer="defer"></script>
<script src="<?php echo base_url('assets/js/menu/script.js')?>" defer="defer"></script>
<script src="<?php echo base_url('assets/js/banner_carteira.js')?>" defer="defer"></script>
<script src="<?php echo base_url('assets/js/banner_mobile.js')?>" defer="defer"></script>
<!-- Acessibilidade - Tamanho da Fonte -->
<script src="<?php echo base_url('assets/js/acessibilidade.js')?>" type="text/javascript" defer="defer"></script>
</body>
</html>
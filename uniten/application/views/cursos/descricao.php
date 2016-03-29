<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" />
<p class="editoria">Curso</p>
<h1><?php echo $curso['nome'] ?></h1>
<h4>REQUISITOS</h4>
<h5>
    <?php echo strip_word_html(str_replace('\\','',nl2br($curso['requisitos'])),'<p><br>'); ?></h5>
<hr>
<h4>DISCIPLINAS</h4>
<?php
$total = 0;
foreach ($curso['disciplinas'] as $disciplina) {
    $total += (int)$disciplina['cargaHoraria'];
?>

<h5>
    <a href="<?php echo base_url() ?>disciplinas/detalhe/<?php echo $disciplina['id']?>" class="fancybox fancybox.iframe"  >
                  <?php echo $disciplina['nome'] ?> (<?php echo $disciplina['cargaHoraria'] ?> horas)
    </a>
</h5>
<?php } ?>

<h5>Carga horária total: <?php echo $total ?> horas </strong></h5>
<hr>

<span class="pubBorder"></span>
<h2><a href="<?php echo base_url('cursos/index/'.$offset)?>">voltar</a> </h2>


<script type="text/javascript">
    $(document).ready(function() {

        $('a.fancybox').fancybox(
			{
        	'autoDimensions'	: false,
			'width'         		: 500,
			'height'        		: 'auto',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
			}
		);

    });
</script>

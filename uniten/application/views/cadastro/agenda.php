<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" />
<link href="<?php echo base_url() ?>assets/css/form2.css" rel="stylesheet" type="text/css">

<p class="editoria">Curso</p>
<h1><?php echo $agenda['curso']['nome'] ?></h1>
<h4>INFORMAÇÕES</h4>
<h5>Local do Curso: <strong><?php echo $agenda['local']['local'] ?> -
    (15) <?php echo $agenda['local']['telefone'] ?></strong></h5>
<h5>Endereço: <strong><?php echo $agenda['local']['endereco'] ?></strong> nº <strong><?php echo $agenda['local']['numero'] ?></strong>
    - <strong><?php echo $agenda['local']['bairro'] ?>  </strong>
      <!--<a href="<?php echo base_url() ?>cursos/mapa" rel="acaolink" class="imap" title="<?php echo $agenda['local']['local'] ?> ">( Mapa )</a>-->
</h5>
<h5>Número de vagas: <strong><?php echo $agenda['vagas'] ?></strong></h5>

<h5>Período de aulas: <strong><?php echo $this->utilmanager->dataBR($agenda['dataInicio']) ?>
    à <?php echo $this->utilmanager->dataBR($agenda['dataTermino']) ?></strong></h5>

<h5>Horário: <strong><?php echo $agenda['horarioInicial'] ?>h às <?php echo $agenda['horarioFinal'] ?></strong></h5>
<h5>Idade mínima: <strong><?php echo $agenda['idade'] ?> anos</strong></h5>
<h5>Requisitos: <strong><?php echo $agenda['curso']['requisitos'] ?></strong></h5>
<hr>

<h4>DISCIPLINAS</h4>
<?php
$total = 0;
foreach ($agenda['curso']['disciplinas'] as $disciplina) {
    $total += (int)$disciplina['cargaHoraria'];
?>

<h5>
    <a href="<?php echo base_url() ?>disciplinas/detalhe/<?php echo $disciplina['id']?>" class="fancybox fancybox.iframe" title="<?php echo $disciplina['nome'] ?>" >
                  <?php echo $disciplina['nome'] ?> (<?php echo $disciplina['cargaHoraria'] ?> horas)
    </a>
</h5>


<?php } ?>

<h5>Carga horária total: <strong><?php echo $total ?></strong> horas </strong></h5>
<hr>
<h4>INSCRIÇÕES</h4>
<h5>Período de incrições: <strong><?php echo $this->utilmanager->dataBR($agenda['dataInicioInscricao']) ?></strong>
    à <strong><?php echo $this->utilmanager->dataBR($agenda['dataFinalInscricao']) ?></strong></h5>
<h5>Local de inscrição: <strong><?php echo $agenda['localInscricao'] ?></strong></h5>
<h5>Prova para classificação: <strong><?php echo $agenda['prova'] == 1 ? 'Sim' : 'Não' ?></strong></h5>
<?php if ($agenda['prova'] == 1) { ?>
    <h5>Data da prova: <strong><?php echo $this->utilmanager->dataBR($agenda['provaData']) ?></strong></h5>
    <h5>Local da prova: <strong><?php echo $agenda['provaLocal'] ?></strong></h5>
    <h5>Horário da prova: <strong><?php echo $agenda['provaHorario'] ?></strong></h5>

<?php } ?>
<?php if (!empty($agenda['obs'])) { ?>
    <h5>Observação: <strong><?php echo $agenda['obs'] ?></strong></h5>
<?php } ?>
<hr>



<div id="div-botton">
    <div align="center" class="row-grid">
        <?php if ($agenda['inscricaoweb'] == 1) {
            $inicioInscri = strtotime($agenda['dataInicioInscricao']);
            $termininoInscri = strtotime($agenda['dataFinalInscricao']);
            $dataatual = strtotime(date("Y-m-d"));
            ?>
            <?php if ($inicioInscri <= $dataatual && $dataatual <= $termininoInscri) { ?>
	         <div class="span3 ">
                        <input name="button" type="submit"  id="button" value="Realizar a Inscrição" tabindex="12"  onclick="self.location='<?php echo base_url(); ?>cadastro'" />
            </div>
            <?php } ?>
        <?php } ?>
          <div class="span1">
                        <input name="voltar2" type="button" value="Voltar" onclick="history.back()"/>
          </div>
        
        
        
        
    </div>
</div>
<div class="row-grid">
                   
                    
                       
                </div>

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
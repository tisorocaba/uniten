<?php
$classif   = ((int)$classificacao - (int)$agenda['vagas']);
?>


<link href="<?php echo base_url() ?>assets/css/form2.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>

<p class="editoria">Cursos > Inscrição Confirmação</p>

<h2>ATENÇÃO</h2>

<hr>

<div id="div-form" style="width: 100%">
    <div id="div-int">

        <?php if( $classif <= 0 ) { ?>
        Sua inscrição para o curso de <strong><?php echo $agenda['curso']['nome'] ?></strong> foi realizada com sucesso!

        <h3 align="center">Protocolo de Inscrição: <?php echo $agenda['id'] . '-' . $aluno['id'] ?></h3>


        <h4 align="center">Local da Prova: <?php echo $agenda['provaLocal'] ?></h4>

        <h4 align="center">Data: <?php echo $agenda['provaData'] ?></h4>

        <h4 align="center">Horário: <?php echo $agenda['provaHorario'] ?></h4>

        <?php if ($agenda['obs']) { ?>
            <h4>Obs: <?php echo nl2br($agenda['obs']) ?></h4>
        <?php } ?>
        <?php }else{ ?>

            Todas a vagas para o curso de <strong><?php echo $agenda['curso']['nome'] ?></strong> já foram preenchidas.
            <br />Você aguardará na lista de espera por vagas remanescentes.

            <h3 align="center">Você é o número <font color="#0000FF" size="+1"><?php echo $classif ?></font>   na lista de espera.</h3>

        <?php } ?>

        <div class="row-grid">
            <div class="span4">
                <input name="button" type="button" class="input_bt" id="button" value="Voltar" tabindex="12"
                       onclick="self.location='../cursos'"/>
            </div>
        </div>
    </div>
</div>










<link href="<?php echo base_url() ?>assets/css/form2.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>
<p class="editoria">Cursos > Inscrição Confirmação</p>

<h2>ATENÇÃO</h2>

<hr>
<div id="div-form" style="width: 100%">
    <div id="div-int">
        Sua inscrição para o curso de <strong><?php echo $agenda['curso']['nome']?></strong> já foi realizada!
        <br>

        <div class="row-grid">
            <div class="span6">
                <h3 align="center">Data da realização da inscrição:  <?php echo $this->utilmanager->dataBR($this->session->flashdata('dataCadastro'));?></h3>

            </div>
        </div>

        <div class="row-grid">
            <div class="span4">
                <input name="button" type="button" class="input_bt" id="button" value="Voltar" tabindex="12"
                       onclick="self.location='../cursos'"/>
            </div>
        </div>
    </div>
</div>






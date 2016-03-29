<link href="<?php echo base_url() ?>assets/css/form2.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>

<script src="<?php echo base_url() ?>assets/js/jquery.maskedinput.js"></script>
<script src="<?php echo base_url() ?>assets/scripts/cadastro/index.js"></script>
<p class="editoria">Cursos > Formulário de Inscrição</p>

<h2>ATENÇÃO</h2>

<hr>
<div id="div-form" style="width: 100%">
        <div id="div-int">
            Houve conflito de horários do curso atual <strong> <?php echo $this->session->flashdata('curso');?> </strong> como o curso pretendido. <br />
            Aguarde o término do curso atual, ou selecione outro curso com horários diferentes.


            <div class="row-grid">
                <div class="span6">
                    <input name="button" type="button" class="input_bt" id="button" value="Voltar" tabindex="12" onclick="self.location='../cursos'"  />
                </div>
            </div>
        </div>
</div>






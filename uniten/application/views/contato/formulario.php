<link href="<?php echo base_url() ?>assets/css/form2.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>
<script src="<?php echo base_url() ?>assets/scripts/cadastro/formulario.js"></script>
<p class="editoria">Contato > Fale Conosco</p>

<?php echo form_open('contato/enviacontato', array('id' => 'form1', 'class' => 'form')); ?>
<input type="hidden" name="crf" value="<?php echo $token?>">


<h1>Formulário</h1>


<div style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px">
    <?php echo validation_errors(); ?>
</div>
<div id="div-form" style="width: 100%">
    <div id="div-int">

        <div class="row-grid">
            <div class="span3 label">
                <span>Nome:*</span>
                <input  id="nome" name="nome" maxlength="95"
                        value="<?php echo set_value('nome'); ?>" size="12"
                         type="text" tabindex="1">
                         <span
                             style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px">
                             <?php echo form_error('nome'); ?>
                         </span>

            </div>
        </div>
        
         <div class="row-grid">
            <div class="span3 label ">
                <span>Email:*</span>
                <input name="email" type="text" size="40" required="required" maxlength="110" id="email" value="<?php echo set_value('email'); ?>"  />
            </div>

        </div>
        
         <div class="row-grid">
            <div class="span0 label no-margin">
                <span>Telefone</span>
                <input name="ddd" type="text" size="2" maxlength="2" id="ddd"  value="<?php echo set_value('ddd'); ?>" onKeyPress="return sonumero(event)" />
            </div>
            <div class="span1 label ">
                <span>Contato:</span>
                <input name="telefone" type="text" size="9" maxlength="9" id="telefone" value="<?php echo set_value('telefone'); ?>"   onKeyPress="return sonumero(event)" />
            </div>
        </div>

  <div class="row-grid">
            <div class="span3 label ">
                <span>Assunto:*</span>
                <input name="assunto" type="text" size="40" maxlength="50" id="assunto" value="<?php echo set_value('assunto');?>"  required="required"/>
            </div>

        </div>
        
        <div class="row-grid">
            <div class="span3 label ">
                <span>Mensagem:*</span>
                   <textarea name="mensagem" id="mensagem" required="required" cols="85" rows="7"><?php echo set_value('mensagem');?></textarea>
            </div>


        </div>
        

        
        
        
        
         <div class="row-grid">
            <div class="span3 label">
                <input name="enviar" type="submit" value="Enviar"  />
            </div>
           
        </div>




    </div>
</div>
</form>

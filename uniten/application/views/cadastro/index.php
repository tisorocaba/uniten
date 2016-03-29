<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" />

<link href="<?php echo base_url() ?>assets/css/form2.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>

<p class="editoria">Cursos > Formulário de Inscrição</p>



    <h2><?php echo $agenda['curso']['nome'] ?></h1>

    <h3 class="section">Local: <?php echo $agenda['local']['local'] ?></h3>

    <h3> Início das aulas: <?php echo $this->utilmanager->dataBR($agenda['dataInicio']) ?></h3>

<hr>

    <div id="div-form" style="width: 100%">
        <div id="div-int">

            <form action="<?php echo base_url() ?>cadastro/consulta" method="post" id="form" class="form" name="form1">

                <div class="row-grid">
                    <div class="span3 label">
                        <span>Data de Nascimento:*</span>
                        <input  id="dataNascimento" name="dataNascimento" maxlength="10"
                               value="<?php echo @set_value('dataNascimento'); ?>" size="12"
                               placeholder="ex: 10/10/2001" required type="text" tabindex="1" onKeyPress="return mascaraGenerica(event, this, '##/##/####')">
                         <span
                             style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px"><?php echo form_error('dataNascimento'); ?><?php echo $this->session->flashdata('erroData'); ?></span>

                    </div>
                </div>

                <div class="row-grid">
                    <div class="span3 label">
                        <span>CPF:*</span>
                        <input  id="cpf" name="cpf" maxlength="12"
                                value="<?php echo @set_value('cpf'); ?>"
                                placeholder="Informe o seu CPF" required type="text" tabindex="1"  onKeyPress="return sonumero(event)" >
                         <span
                             style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px"><?php echo form_error('cpf'); ?></span>

                    </div>
                </div>

                <div class="row-grid">
                    <div class="span2 termo">
                        <input name="termo" id="termo" type="checkbox" value="S" required  />
                        Li e concordo com o <a href="<?php echo base_url('paginas/manualaluno') ?>/manualaluno/termo" rel="acaolink"
                                               title="Manual do Aluno" class="fancybox fancybox.iframe" >manual do aluno</a>
                <span
                    style="color:#FF0000;font-family:Verdana, Geneva, sans-serif;font-size:9px"><?php echo form_error('termo'); ?></span>
                    </div>
                </div>

                <div class="row-grid">
                    <div class="span3 ">
                        <input name="button" type="submit"  id="button" value="Continuar" tabindex="12"  />
                    </div>
                    
                     <div class="span2">
                        <input name="voltar2" type="button" value="Voltar" onclick="history.back()"/>
                    </div>
                    
                       
                </div>

            </form>

        </div>
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


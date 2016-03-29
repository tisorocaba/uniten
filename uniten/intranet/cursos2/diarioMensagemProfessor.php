<?php
require_once '../util/config.php';
Security::cursoSecurity();

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'diarioMensagemProfessor', 'ERRO(1056) :: tentou acessar outro diario de outro curso');
  
?>


<div class="error-page">
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> AVISO</h3>
        <p>
        <?php if($_GET['op']===1){ ?>
            Prazo para inserção ou alteração desse diário de classe venceu. <br />Para mais informações, entre em contato a UNITEN.
        <?php }else{ ?>
             O Diário só pode ser preenchido após a sua data. <br />Para mais informações, entre em contato a UNITEN.
        <?php } ?>
        </p>
        <form class='search-form'>
            <div class='input-group'>
              
                <div class="input-group-btn">
                     <input name="btVoltar" type="button" value="voltar" class="btn  btn-primary"  onclick="self.location='principal.php?acao=diarios'" />
                </div>
            </div><!-- /.input-group -->
        </form>
    </div>
</div><!-- /.error-page -->


<?php
require_once '../util/config.php';
Security::cursoSecurity();
$projeto = new Projeto();
$projeto->alias('p')->order('p.nome ASC')->find();

if(!empty($_GET['id']))
{
   $obj = new Local();
   $obj->get($_GET['id']);
   $_POST = $obj->toArray();
}
logDao::gravaLog($user->login, 'senhaCadastro', 'Acessou: alteracao de senha');
?>
<link href="../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-v2.1.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript"  src="scripts/senhaCadastro.js"></script>

<h4 class="page-header">
    Alterar Senha <small>
    </small>
</h4>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <div class="box box-primary">
            
            <?php if(!empty($_SESSION['ERROS'])){?>
            <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Erros!</b> <br>
                                        <?php echo implode('<br>',$_SESSION['ERROS']) ?>
          </div>
            <?php } ?>
            <!-- form start -->
          <form name="form1" method="post" id="form1" action="usuarioLogic.php">
	<input type="hidden" name="id" value="<?php echo @$user->id?>"  />
    <input type="hidden" name="empresa" value="<?php echo @$user->empresa->id?>"  />

                <div class="box-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Usuário: </label>
                        <?php echo @$user->nome?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Login: </label>
                        <?php echo @$user->login?>
                    </div>

                    <div class="form-group">
                        Senha:
                        <input class="form-control validate[required,minSize[6]]"  value="<?php echo @$_POST['senha'] ?>" id="senha"  name="senha"  type="password" style="width: 120px">   
                    </div>
                    
                    <div class="form-group">
                        Confirma senha:
                        <input class="form-control validate[required,equals[senha]]"   value="<?php echo @$_POST['csenha'] ?>" id="csenha"  name="csenha"  type="password" style="width: 120px">  
                    </div>
                  </div><!-- /.box-body -->

       

                <div class="box-footer">
                 
                        <input type="hidden" name="acao" value="alterarsenha">
                        <input type="submit" name="btGravar" id="btGravar" value="alterar" class="btn btn-default">
                        <input name="btVoltar" type="button" value="voltar" class="btn  btn-primary"  onclick="self.location='principal.php'" />
                </div>
            </form>
        </div>
    </div>
</div>


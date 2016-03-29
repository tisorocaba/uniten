<?php
require_once '../util/config.php';
Security::cursoSecurity();

$empresas = new Empresa ();
$empresas->alias ('p')->order ('p.nome ASC')->find ();
logDao::gravaLog($user->id, 'gastos', $_REQUEST ['acao'], $_REQUEST);

logDao::gravaLog($user->login, 'gastos', 'Acessou: Controle Financeiro',$_REQUEST);
?>
<link href="../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-v2.1.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/financeiro.js"></script>

<h4 class="page-header">
    Confrole financeiro</h4>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <div class="box box-primary">
            
            
          <form action="financeiroPesquisa.php" method="post" name="form1" id="form1">
                <input type="hidden" name="empresa" value="<?php echo $user->empresa->id?>" />

                <div class="box-body">

                    <div class="form-group"></div>
<div class="form-group">
              Data Início:
                <input class="form-control  validate[required]"  data-inputmask="'alias': 'dd/mm/yyyy'"  value="<?php echo @$_POST['data_inicio'] ?>" id="data_inicio"  name="data_inicio"  type="text" style="width: 120px">   
                    </div>
                    
                    <div class="form-group">Data Final:
                          <input class="form-control validate[required]" data-inputmask="'alias': 'dd/mm/yyyy'"   value="<?php echo @$_POST['data_fim'] ?>" id="data_fim"  name="data_fim"  type="text" style="width: 120px">  
                    </div>
                  </div><!-- /.box-body -->

       

                <div class="box-footer">
                 
                        <input type="hidden" name="acao" value="alterarsenha">
                        <input type="submit" name="btGravar" id="btGravar" value="emitir" class="btn btn-default">
                </div>
            </form>
        </div>
    </div>
</div>


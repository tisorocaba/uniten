<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
Security::cursoSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$aluno = $agenda->escape($_REQUEST['cod']);

$agendaDao = new AgendaCursoDao();

$aluno = $agendaDao->getAgendaAluno($_SESSION['CODAGENDA'], $aluno);

if(!empty($_GET['id']))
{
   $obj = new DiarioClasse();
   $obj->get($obj->escape($_GET['id']));
   $_POST = $obj->toArray();
   $_POST['data'] = data_br($_POST['data']);
   $lbBotao = "Alterar";
}else{
   $lbBotao = "Continuar";
}

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'alunoCadastrAvaliacao', 'Acessou: cadastro de avaliacao',$_REQUEST,'','Aluno: '.$_REQUEST['cod']);
?>
<link href="../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-v2.1.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/alunoCadastrAvaliacao.js" type="text/javascript"></script>

 <form action="avaliacaoFinalLogic.php" method="post" id="form1">
           <input name="aluno" type="hidden" value="<?php echo @$_REQUEST['cod']?>" />
           <input name="acao" type="hidden" value="gravar" />
<h4 class="page-header">
    Cursos :: Avaliação Final :: Inclusão <small>
        Curso: <?php echo $agenda->curso->nome ?>
    </small>
</h4>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Avaliação final</h3>

            </div><!-- /.box-header -->
            <?php if(!empty($_SESSION['ERROS'])){?>
            <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Erros!</b> <br>
                                        <?php echo implode('<br>',$_SESSION['ERROS']) ?>
                                    </div>
            <?php } ?>
            <!-- form start -->
          
                   
                <div class="box-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Aluno: </label>
                        <?php echo Aluno::staticGet($agenda->escape($_REQUEST['cod']))->nome; ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Curso: </label>
                         <?php echo $agenda->curso->nome; ?>
                    </div>

                    <div class="form-group">
                    <div class="row">
                                        <div class="col-xs-3">
                                               Nota : &nbsp;
                                               <select name="nota" id="cbnota" style="width:50px; height:25px">
                                              <option value="0" <?php if( $aluno->nota == 0) echo "selected=\"selected\""?> >0</option>
                                              <option value="1" <?php if( $aluno->nota == 1) echo "selected=\"selected\""?>>1</option>
                                              <option value="2" <?php if( $aluno->nota == 2) echo "selected=\"selected\""?>>2</option>
                                              <option value="3" <?php if( $aluno->nota == 3) echo "selected=\"selected\""?>>3</option>
                                              <option value="4" <?php if( $aluno->nota == 4) echo "selected=\"selected\""?>>4</option>
                                              <option value="5" <?php if( $aluno->nota == 5) echo "selected=\"selected\""?>>5</option>
                                              <option value="6" <?php if( $aluno->nota == 6) echo "selected=\"selected\""?>>6</option>
                                              <option value="7" <?php if( $aluno->nota == 7) echo "selected=\"selected\""?>>7</option>
                                              <option value="8" <?php if( $aluno->nota == 8) echo "selected=\"selected\""?>>8</option>
                                              <option value="9" <?php if( $aluno->nota == 9) echo "selected=\"selected\""?>>9</option>
                                              <option value="10" <?php if( $aluno->nota == 10) echo "selected=\"selected\""?>>10</option>
                                            </select>
                                        </div>
                                       
                                   
                      
                         
                    </div>
                    
                </div><!-- /.box-body -->

               

               
           
        </div>
         <div class="box-footer">
                    
                    
                        <input name="Continuar" type="submit" class="btn btn-success " value="<?php echo $lbBotao?>"  />
                     
                        <input name="btVoltar" type="button" value="voltar" class="btn  btn-primary"  onclick="self.location='principal.php?acao=alunosAvaliacaoFinal'" />
                </div>
    </div>
</div>

 </form>

<?php
require_once '../util/config.php';
require_once '../dao/agendaDisciplinaProfessorDao.php';
require_once '../dao/agendaCursoDao.php';
require_once '../dao/diarioClasseDao.php';
Security::cursoSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$diarioDao = new DiarioClasseDao();

$projeto = new Projeto();
$projeto->get($agenda->local->projeto);

$agendaDiscplinaProfessorDao = new AgendaDisciplinaProfessorDao();
$professores = $agendaDiscplinaProfessorDao->listaProfessorAgendaAgrupado($_SESSION['CODAGENDA']);
$isAlterar = true;
if (!empty($_REQUEST['id'])) {
    $obj = new DiarioClasse();
    $obj->get($obj->escape($_GET['id']));

    if (calculaDiferencaDataAtual(data_br($obj->data)) > 1) {
        $isAlterar = false;
    }



    if ($obj->agenda != $_SESSION['CODAGENDA']) {
        $_REQUEST['ERRO'] = 'FALTA DE CODIGO';
        $user = unserialize($_SESSION['USER']);
        logDao::gravaLog($user->login, 'diarioCadastroProfessor', 'ERRO(1056) :: tentou acessar outro diario de outro curso', $_REQUEST, '', 'Diario: ' . $_GET['id']);
        die('ERRO(1056) :: ACESSO NEGADO');
    }

    $_POST = $obj->toArray();
    $_POST['data'] = data_br($_POST['data']);
    $lbBotao = "alterar";
    logDao::gravaLog($user->login, 'diarioCadastroProfessor', 'Acessou: ficha de cadastro de diario(alteracao)', $_REQUEST, '', 'Diario: ' . $_GET['id']);
} else {
    die("ERRO: ACESSO NEGADO");
    $lbBotao = "gravar";
    logDao::gravaLog($user->login, 'diarioCadastroProfessor', 'Acessou: ficha de cadastro de diario(novo cadastro)', $_REQUEST);
}

$agendaDao = new AgendaCursoDao();
$alunos = $agendaDao->listaAlunoAgenda($_SESSION['CODAGENDA']);
?>
<link href="../css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-v2.1.js" type="text/javascript" charset="utf-8"></script>

<script src="../js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="scripts/diarioCadastro.js" type="text/javascript"></script>

<h4 class="page-header">
    Cursos :: Diários de Classe :: Inclusão <small>
        Curso: <?php echo $agenda->curso->nome ?>
    </small>
</h4>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Informações do curso</h3>

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
            <form role="form" action="diarioLogic.php" method="post" id="form1">
                    <input name="id" type="hidden" value="<?php echo @$_REQUEST['id']?>" />
                    <input name="acao" type="hidden" value="gravar" />
                    <input type="hidden" id="disciplina" value="<?php echo @$_POST['disciplina']?>" />
                    <input type="hidden" id="datahoje" value="<?php echo date("d/m/Y")?>" />

                    <input type="hidden" name ="totalAlunos" value="<?php echo count($alunos)?>" /> 
                <div class="box-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Projeto: </label>
                        <?php echo $projeto->nome; ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Local: </label>
                        <?php echo $agenda->local->local; ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Data da aula: </label>
                        <?php echo @$_POST['data'] ?>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Professor: </label>
                        <?php echo $user->nome ?>
                        <input type="hidden" name="professor" id="cbProfessor" value="<?php echo $user->professor ?>" >
                    </div>
                    <div class="form-group" id="linhaDisciplinas" style="display:none">
                        <label>Disciplina: <br></label>
                        <span id="cbDisciplinas">
                            <select class="form-control"></select>
                        </span>
                    </div>
                    <div class="form-group">
                        Horas utilizadas:
                        <input class="form-control validate[required]"  value="<?php echo @$_POST['horas'] ?>" id="horas"  name="horas"  type="text" style="width: 60px"> *  ex: 4:00
                    </div>
                    <div class="form-group">
                        <label>Conteúdo Programático:</label>
                        <textarea class="form-control validate[required]" name="conteudo" id="conteudo" rows="3" placeholder=""><?php echo @$_POST['conteudo'] ?></textarea><span id="lbConteudo"></
                    </div>
                </div><!-- /.box-body -->

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Lista de presença</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Aluno</th>
                                        <th>Presença</th>

                                    </tr>
                                    <?php foreach ($alunos as $aluno) {?>
                                    <tr>
                                        <td style="text-transform:uppercase"><?php echo reduzirNome($aluno->aluno,25); ?></td>
                                        <td>
                                           
                                            <input type="radio"  name="falta-<?php echo $aluno->id ?>" id="faltasim-<?php echo $aluno->id ?>" value="1" class="validate[required]" <?php 
					  if(!empty($_REQUEST['id'])){
					     echo $diarioDao->isCheckedPresenca($_GET['id'], $aluno->id, 1);
					  }
					  
					  ?> />
                        Sim
                        <input type="radio" name="falta-<?php echo $aluno->id ?>" id="faltanao-<?php echo $aluno->id ?>" value="0" class="cssFalta validate[required]" <?php 
						if(!empty($_REQUEST['id'])){
						  echo $diarioDao->isCheckedPresenca($_GET['id'], $aluno->id, 0);
						}
						
						?> />
                        Não 
                                            
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                </div>

                <div class="box-footer">
                    
                      <?php if($isAlterar===true ){  ?>  
                        <input name="Continuar" type="submit" class="btn btn-success " value="<?php echo $lbBotao?>"  />
                      <?php } ?>
                        <input name="btVoltar" type="button" value="voltar" class="btn  btn-primary"  onclick="self.location='principal.php?acao=diarios'" />
                </div>
            </form>
        </div>
    </div>
</div>


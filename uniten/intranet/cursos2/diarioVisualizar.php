<?php
require_once '../util/config.php';
require_once '../dao/diarioClasseDao.php';
Security::cursoSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

if(!empty($_GET['id']))
{
    
    
   $obj = new DiarioClasse();
   $obj->get($obj->escape($_GET['id']));
   
   if( $obj->agenda!=$_SESSION['CODAGENDA']){
       
        $user = unserialize($_SESSION['USER']);
        logDao::gravaLog($user->login, 'diarioVisualizacao', 'ERRO: diario nao pertencente a agenda informada',$_REQUEST,'','Diario: '.$_POST['data'].' Agenda: '.$_SESSION['CODAGENDA']);
           
        die('ERRO(1056) :: ACESSO NEGADO');
   }
   
   $_POST = $obj->toArray();
   $_POST['data'] = data_br($_POST['data']);
   
   $diarioDao = new DiarioClasseDao();
   $alunos = $diarioDao->listaAlunos($obj->escape($_GET['id']));
   
   
  
}else{
    $user = unserialize($_SESSION['USER']);
    $_REQUEST['ERRO'] = 'FALTA DE CODIGO';
         logDao::gravaLog($user->login, 'diarioVisualizacao', 'ERRO: codigo diario nao informado',$_REQUEST);

    die('ERRO(1056) :: ACESSO NEGADO');
}

$user = unserialize($_SESSION['USER']);
//logDao::gravaLog($user->login, 'diarioVisualizacao', '',$_REQUEST);
logDao::gravaLog($user->login, 'diarioVisualizacao', 'Visualizou: diario de classe e as presenças',$_REQUEST,'','Diario: '.$_GET['id'].' Agenda: '.$_SESSION['CODAGENDA']);
    
?>
 <div class="row">
                       
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Informações do Diário</h3>
                                   
                                </div>
                                <div class="box-body">
                                    Professor: <code><?php echo Professor::staticGet($_POST['professor'])->nome?></code>
                                    <p>
                                        Disciplina: <code><?php echo Disciplina::staticGet($_POST['disciplina'])->nome?></code><br />
                                        Data da Aula: <code><?php echo @$_POST['data']?></code><br />
                                  		Horas Utilizadas: <code><?php echo @$_POST['horas']?></code><br />
               							Conteúdo Programático: <code><?php echo !empty($_POST['conteudo'])? nl2br($_POST['conteudo']):''?></code>
                                 </p>
                              </div><!-- /.box-body -->
                               
                            </div><!-- /.box -->
                      
</div>

<div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Alunos</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th width="739" align="left">Nome</th>
                                            <th width="150">Presença</th>
                                            <th width="105">VT</th>
                                        </tr>
                                        <?php foreach ($alunos as $aluno) { ?>
                                        <tr>
                                            <td style="text-transform: uppercase;"><?php echo reduzirNome($aluno->nome,25)?></td>
                                            <td><?php if($aluno->presenca==1) { echo "<span class=\"label label-success\">Sim</span>";}elseif($aluno->presenca==0){ echo "<span class=\"label label-warning\">Não</span>";}else{ echo "<span class=\"label label-warning\">Não informada</span>";} ?></span></td>
                                            <td><?php if($aluno->vale==1) { echo "<span class=\"label label-success\">Sim</span>";}else{ echo "<span class=\"label label-warning\">Não</span>";} ?></span></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div class="box-footer">
                    
                     
                        <input name="btVoltar" type="button" value="voltar" class="btn  btn-primary"  onclick="self.location='principal.php?acao=diarios'" />
               			 </div>
                            
                        </div>
                    </div>
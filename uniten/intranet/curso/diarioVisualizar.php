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
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="../js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.limite-char-1.0.js" type="text/javascript"></script>

<table width="95%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Relatórios de Classes :: Diário de Classe</strong></p>
        </td>
    </tr>
    <tr>
        <td>
          <form action="diarioLogic.php" method="post" id="form1">
           <input name="id" type="hidden" value="<?php echo @$_REQUEST['id']?>" />
           <input name="acao" type="hidden" value="gravar" />
           <input type="hidden" id="disciplina" value="<?php echo @$_POST['disciplina']?>" />
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                <tr>
                    <td colspan="2"><strong>Informações do Diário</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                
                <tr>
                    <td width="22%">Local:</td>
                    <td width="78%"><?php echo AgendaCurso::staticGet($_POST['agenda'])->local->local?>
                    </td>
                </tr>
                
                <tr>
                    <td width="22%">Professor:</td>
                    <td width="78%"><?php echo Professor::staticGet($_POST['professor'])->nome?>
                    </td>
                </tr>
                <tr id="linhaDisciplinas">
                  <td>Disciplina:</td>
                  <td>
                     <?php echo Disciplina::staticGet($_POST['disciplina'])->nome?>
                  </td>
                </tr>
                <tr>
                    <td>Data da Aula:</td>
                    <td><?php echo @$_POST['data']?></td>
                </tr>

                <tr>
                  <td>Horas Utilizadas:</td>
                  <td><?php echo @$_POST['horas']?></td>
                </tr>
                <tr>
                  <td>Conteúdo Programático:</td>
                  <td><?php echo @$_POST['conteudo']?></td>
                </tr>

                <tr>
                    <td colspan="2"><strong>Alunos</strong></td>
                </tr>
                <tr>
                  <td colspan="2" align="left"><hr /></td>
                </tr>
                <tr>
                    <td colspan="2" align="left"><table width="100%" border="0">
                      <tr>
                        <td width="84%" bgcolor="#CCCCCC" ><strong>Nome</strong></td>
                        <td width="11%" bgcolor="#CCCCCC" align="right"><strong>Presença</strong></td>
                        <td width="5%" bgcolor="#CCCCCC" align="right"><strong>VT</strong></td>
                      </tr>
                      <?php 
                          $cont = 0;
                          foreach ($alunos as $aluno) { 
                          
                           
                                     if ($cont === 0) {
                                            $linha = "listaClara";
                                            $cont = 1;
                                      } else {
                                            $linha = "listaEscura";
                                            $cont = 0;
                                      }
                          
                          ?>
                          
                      
                      <tr class="<?php echo $linha ?>">
                        <td  style="text-transform: uppercase;"><?php echo $aluno->nome?></td>
                        <td align="right"><?php if($aluno->presenca==1) { echo "Sim";}elseif($aluno->presenca==0){ echo "Não";}else{ echo "Não informada";} ?></td>
                        <td align="right"><?php if($aluno->vale==1) { echo "Sim";}else{ echo "Não";} ?></td>
                      </tr>
                      <?php }?>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input name="alterar" value="voltar" type="button" onclick="self.location='principal.php?acao=diarios&agenda=<?php echo $_SESSION['CODAGENDA']?>'" />
                    &nbsp;
                  <input name="imprimir" value="imprimir" type="button" onclick="print();" /></td>
                </tr>
            </table>
           </form>
        </td>
    </tr>
</table>

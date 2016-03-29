<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$motivo = new DesistenciaMotivo();
$motivo->find();
$user = unserialize($_SESSION['USER']);


$_aluno = $agenda->escape($_REQUEST['aluno']);
$agendaDao = new AgendaCursoDao();
$aluno = $agendaDao->getAgendaAluno($_SESSION['CODAGENDA'], $_aluno);

$desistencia = new Desistencia();
$desistencia->alias('d')->where('d.agenda=? and d.aluno=?',$_SESSION['CODAGENDA'], $_aluno)->find();

if(count($desistencia->allToArray()>0))
{
    $_POST = $desistencia->allToArray();
    $lbBotao = "Alterar";
     logDao::gravaLog($user->login, 'desistenciaCadastro', 'Acessou: cadastro de desistencia(alteracao)',$_REQUEST,'','Aluno: '.$_REQUEST['aluno']);

}else{
   $lbBotao = "Confirmar ";
    logDao::gravaLog($user->login, 'desistenciaCadastro', 'Acessou: cadastro de desistencia(novo)',$_REQUEST);

}



?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="scripts/desistenciaCadastro.js" type="text/javascript"></script>
<table width="95%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Aluno :: Desistência</strong></p>
        </td>
    </tr>
    <tr>
        <td>
          <form action="desistenciaLogic.php" method="post" id="form1">
           <input name="aluno" type="hidden" value="<?php echo $_aluno?>" />
           <input name="acao" type="hidden" value="gravar" />
           <input name="id" type="hidden" value="<?php echo @$_POST[0]['id']?>" />


           <input name="tipo" id="tipo" type="hidden" value="1" />
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                <tr>
                    <td colspan="2"><strong>Dados do Aluno</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td width="28%">Aluno:</td>
                    <td width="72%" style="text-transform: uppercase">
                        <?php echo Aluno::staticGet($agenda->escape($_REQUEST['aluno']))->nome; ?>
                    </td>
                </tr>
                <tr>
                    <td>Curso:</td>
                    <td>
                        <?php echo $agenda->curso->nome; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Dados da Desistência</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td>Justificou a desistência:</td>
                    <td><label for="fileField"></label>
                      <select name="desistencia" id="cbDesistencia">
                          <option value="1" <?php if(@$_POST[0]['id']==1) echo 'selected' ?> >Sim</option>
                        <option value="0" <?php if(@$_POST[0]['id']==0) echo 'selected' ?>>Não</option>
                    </select></td>
                </tr>

                <tr id="linhaMotivo">
                  <td>Motivo:</td>
                  <td>
                      
                      
                      <select name="motivo" id="cbMotivos" class="validate[required]">
                        <option value="">Selecione...</option>
                         <?php echo Lumine_Util::buildOptions($motivo, 'id', 'nome', @$_POST[0]['motivo']); ?>
                     </select>
                      
                      
                  *</td>
                </tr>
                <tr id="linhaAviso">
                  <td>&nbsp;</td>
                  <td>
                  <font color="#FF0000">
                     Atenção: em caso de desistência não justificada, o aluno ficará impedido de se matricular em qualquer curso por 60 dias.</font>  
                   </td>
                </tr>
                <tr id="linhaDescricao">
                  <td>Texto:</td>
                  <td>
                  <textarea name="descricao" id="descricao" cols="45" rows="5"><?php echo @$_POST[0]['descricao']?></textarea></td>
                </tr>

                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                    <td align="left"><input name="Continuar" type="submit" value="<?php echo $lbBotao?>"  />
                    <input type="button" name="button" id="button" value="voltar" onclick="history.go(-1)" /></td>
                </tr>
            </table>
           </form>
        </td>
    </tr>
</table>

<?php
require_once 'util/config.php';
Security::admSecurity();
require_once 'dao/agendaCursoDao.php';
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$aluno = $agenda->escape($_REQUEST['cod']);

$agendaDao = new AgendaCursoDao();

$aluno = $agendaDao->getAgendaAluno($_SESSION['CODAGENDA'], $aluno);
$user = unserialize($_SESSION['USER']);
if(!empty($_GET['cod']))
{
   $obj = new DiarioClasse();
   $obj->get($obj->escape($_GET['cod']));
   $_POST = $obj->toArray();
   $_POST['data'] = data_br($_POST['data']);
   $lbBotao = "Alterar";
   logDao::gravaLog($user->login, 'alunoCadastrAvaliacao', 'Acessou: cadastro de avaliacao(alteracao)',$_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA'].' Aluno: '.$_REQUEST['cod']);
}else{
   $lbBotao = "Continuar";
    logDao::gravaLog($user->login, 'alunoCadastrAvaliacao', 'Acessou: cadastro de avaliacao(novo)',$_REQUEST);

}



?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery-v2.1.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="scripts/alunoCadastrAvaliacao.js" type="text/javascript"></script>
<script src="js/funcoes.js"></script>
<table width="95%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Avaliação Final </strong></p>
        </td>
    </tr>
    <tr>
        <td>
          <form action="avaliacaoFinalLogic.php" method="post" id="form1">
           <input name="aluno" type="hidden" value="<?php echo @$_REQUEST['cod']?>" />
           <input name="acao" type="hidden" value="gravar" />
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
                        <?php echo Aluno::staticGet($agenda->escape($_REQUEST['cod']))->nome; ?>
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
                    <td colspan="2"><strong>Dados da avaliação</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td>Nota final:</td>
                    <td>
                    <select name="nota" id="cbnota" class="validate[required]">
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
                    *</td>
                </tr>

                <!-- <tr>
                  <td>Status:</td>
                  <td><label for="status"></label>
                      <select name="status" id="status">
                        <option value="2" <?php if($aluno->status==2) echo 'selected'?> >Aprovado</option>
                        <option value="3" <?php if($aluno->status==3) echo 'selected'?>>Reprovado</option>
                    </select>*</td>
                </tr>
                -->

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

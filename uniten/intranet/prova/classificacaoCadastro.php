<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
Security::provaSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$_aluno = $agenda->escape($_REQUEST['aluno']);
$agendaDao = new AgendaCursoDao();
$aluno = $agendaDao->getAgendaAluno($_SESSION['CODAGENDA'], $_aluno);

$class = "";
if(!empty($aluno->classificacao))
{
 	 
	 $class = $aluno->classificacao;
     $lbBotao = "alterar";
}else{
   $lbBotao = "gravar";
}


$user = unserialize($_SESSION['USER']);

logDao::gravaLog($user->login, 'classificacaoCadastro', 'Acessou: ficha de classificacao de candidato ', $_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA'].' Candidato: '.$_aluno);
?>
<link href="../intranet.css" rel="stylesheet" type="text/css">
<link href="../css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="../js/jquery-1.5.min.js"              type="text/javascript"></script>
<script src="../js/jquery.maskedinput.js"         type="text/javascript"></script>
<script src="../js/jquery.validationEngine.js"    type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.limite-char-1.0.js"     type="text/javascript"></script>
<script src="../js/funcoes.js"                     type="text/javascript"></script>
<script src="scripts/classificacaoCadastro.js" type="text/javascript"></script>

<table width="95%" border="0" cellspacing="0" cellpadding="15">
    <tr>
        <td valign="top" style="text-align:justify;">
            <p><strong class="titulo">Aluno :: Classificação</strong></p>
        </td>
    </tr>
    <tr>
        <td>
          <form action="classificacaoLogic.php" method="post" id="form1">
           <input name="aluno" type="hidden" value="<?php echo $_aluno?>" />
           <input name="acao" type="hidden" value="gravar" />
           <input name="id" type="hidden" value="<?php echo $class?>" />


           <input name="tipo" id="tipo" type="hidden" value="1" />
            <table width="100%" border="0" cellspacing="3" cellpadding="1">
                <tr>
                    <td colspan="2"><strong>Aluno</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td width="18%">Nome:</td>
                    <td width="82%" style="text-transform:uppercase">
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
                    <td colspan="2"><strong>Classificação</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td>Colocação:* </td>
                    <td>
                      <input name="classificacao" type="text" id="classificacao" value="<?php echo @$class?>" size="3" maxlength="4" class="validate[required]" onKeyPress="return sonumero(event)"  />
                    º</td>
                </tr>
                <tr>
                  <td align="left">Nota:*</td>
                  <td align="left"><input name="notaProva" type="text" id="notaProva" value="<?php echo @$class?>" size="8" maxlength="6" class="validate[required]"  /> 
                    ex: 45,75 </td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td align="left" style="font-size:9px">* campos obrigatórios</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                    <td align="left"><input name="Continuar" type="submit" value="<?php echo $lbBotao?>"  />
                    <input type="button" name="button" id="button" value="voltar" onclick="self.location='candidatos.php'" /></td>
                </tr>
            </table>
           </form>
        </td>
    </tr>
</table>

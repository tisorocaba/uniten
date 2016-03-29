<?php
require_once 'util/config.php';
require_once 'dao/agendaDisciplinaProfessorDao.php';
Security::admSecurity();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$agendaDiscplinaProfessorDao = new AgendaDisciplinaProfessorDao();
$professores = $agendaDiscplinaProfessorDao->listaProfessorAgendaAgrupado($_SESSION['CODAGENDA']);




$projeto = new Projeto();
$projeto->get($agenda->local->projeto);

/*$professores = new Professor();
$professores->alias('p')->order('p.nome ASC')->find();*/

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


logDao::gravaLog($user->login, 'diarioCadastro', 'Acessou: cadastro de diario(novo)',$_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);
?>
<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="css/validationEngine.jquery.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.limite-char-1.0.js" type="text/javascript"></script>
<script src="scripts/diarioCadastro.js" type="text/javascript"></script>
<table width="95%" border="0" cellspacing="0" cellpadding="3">
    <tr>
        <td valign="top" style="text-align:justify;">
           <strong class="titulo">Diário de Classe</strong> 
              </td>
    </tr>
    <tr>
        <td>
          <form action="diarioLogic.php" method="post" id="form1">
           <input name="id" type="hidden" value="<?php echo @$_REQUEST['id']?>" />
           <input name="acao" type="hidden" value="gravar" />
           <input type="hidden" id="disciplina" value="<?php echo @$_POST['disciplina']?>" />
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                    <td colspan="2"><strong>Dados do Curso</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td width="28%">Projeto:</td>
                    <td width="72%">
                        <?php echo $projeto->nome; ?>
                    </td>
                </tr>
                <tr>
                    <td>Local:</td>
                    <td>
                        <?php echo $agenda->local->local; ?>
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
                    <td colspan="2"><strong>Informações do Professor</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
                <tr>
                    <td>Professor:</td>
                    <td>
                    <select name="professor" id="cbProfessor" class="validate[required]">
                    <option value="">Selecione...</option>
                    <?php foreach ($professores as $professor) {?> 
                    <option value="<?php echo @$professor->proid?>" <?php if($professor->proid ==@$_POST['professor']) echo "selected"?>>
				<?php echo @$professor->professor?>
                    </option>
                    <?php } ?>
                    
                   </select>
                    *
                    </td>
                </tr>
                <tr id="linhaDisciplinas" style="display:none">
                  <td>Disciplina:</td>
                  <td>
                     <span id="cbDisciplinas"></span>
                  </td>
                </tr>
                <tr>
                    <td>Data da Aula:</td>
                    <td><label for="fileField"></label>
                    <input type="text" name="data" id="data" maxlength="10" size="10" class="validate[required]"  value="<?php echo @$_POST['data']?>" />
                    *</td>
                </tr>

                <tr>
                  <td>Horas Utilizadas:</td>
                  <td><input type="text" name="horas" id="horas" maxlength="4" size="4" class="validate[required]"   value="<?php echo @$_POST['horas']?>"/>
                    *ex: 1:00 ou 1:45</td>
                </tr>
                <tr>
                    <td>Conteúdo Programático:</td>
                    <td><label for="conteudo"></label>
                    <textarea name="conteudo" id="conteudo" cols="70" rows="4" class="validate[required]" ><?php echo @$_POST['conteudo']?></textarea> 
                    &nbsp;<span id="lbConteudo">*</span></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                  <td><input name="Continuar" type="submit" value="<?php echo $lbBotao?>"  /></td>
                </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                </tr>
            </table>
           </form>
        </td>
    </tr>
</table>

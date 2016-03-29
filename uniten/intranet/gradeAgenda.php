<?php
require_once 'util/config.php';
require_once 'dao/diarioClasseDao.php';
require_once 'dao/agendaDisciplinaProfessorDao.php';
Security::admSecurity();
$agenda = new AgendaCurso();
if (!empty($_REQUEST['agenda'])) {
    $_SESSION['CODAGENDA'] = $agenda->escape($_REQUEST['agenda']);
}
$agenda->get($_SESSION['CODAGENDA']);

$agendaDiscplinaProfessorDao = new AgendaDisciplinaProfessorDao();
$disciplinas = $agendaDiscplinaProfessorDao->listaDisciplinaAgenda($_SESSION['CODAGENDA']);


//$qtalunos = count($agenda->getLink('alunos'));
$diarios = new DiarioClasse();
$diarios->alias('d')->where('d.agenda=?', $_SESSION['CODAGENDA'])->order('d.data DESC')->find();
$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'diarios', 'Acessou: lista de diarios',$_REQUEST,'','Agenda: '.$_SESSION['CODAGENDA']);
list($anoIni,$mesIni,$diaIni) = explode("-",$agenda->dataInicio);
list($anoFim,$mesFim,$diaFim) = explode("-",$agenda->dataTermino);

$cargaHorariaTotal = (int)Curso::staticGet($agenda->curso->id)->cargaHorariaTotal();

$inicio = DateTime::createFromFormat('H:i', $agenda->horarioInicial);
$fim = DateTime::createFromFormat('H:i', $agenda->horarioFinal);
$intervalo = $inicio->diff($fim);
$horas = $intervalo->format('%H');

$aulas = ceil($cargaHorariaTotal/$horas);





?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<link href="js/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery.maskedinput.js"></script>
<script src="js/jquery.ui.core.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.widget.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.ui.datepicker.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/gradeAgenda.js" type="text/javascript"></script>
<input type="hidden" id="anoIni" value="<?php echo $anoIni?>" />
<input type="hidden" id="mesIni" value="<?php echo $mesIni?>" />
<input type="hidden" id="diaIni" value="<?php echo $diaIni?>" />
<input type="hidden" id="anoFim" value="<?php echo $anoFim?>" />
<input type="hidden" id="mesFim" value="<?php echo $mesFim?>" />
<input type="hidden" id="diaFim" value="<?php echo $diaFim?>" />
<p><span class="titulo">Grade de Aulas</span><br></p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td width="467" bgcolor="#FFFFFF">Curso: <?php echo $agenda->curso->nome ?>
            <br />
            Data de início: <?php echo data_br($agenda->dataInicio) ?>
        <br />
        Data de término: <?php echo data_br($agenda->dataTermino) ?>
        <br>
        Carga horária: <?php echo $cargaHorariaTotal?> horas
        </td>
        <td width="660" colspan="6" align="right" bgcolor="#FFFFFF"><table width="100%" border="0">
          <tr>
            <td width="17%">Disciplinas:</td>
            <td width="83%">
         
            <select name="disciplina" id="disciplina">
           <?php foreach ($disciplinas as $disciplina) {?>
              <option value="<?php echo @$disciplina->id?>" > 			<?php echo @$disciplina->nome?> </option>
              <?php } ?>
            </select>
            </td>
          </tr>
          <tr>
            <td>Data:</td>
            <td><input type="text" name="data" id="data" maxlength="10" size="10" readonly="readonly"   />
            <input type="submit" name="button" id="btnGravar" value="gravar" /><span id="spnGravando" style="display:none">Gravando...</span></td>
          </tr>
        </table></td>
    </tr>
    <tr class="listaClara">
      <td height="28" colspan="7" bgcolor="#FFFFFF"><hr /></td>
    </tr>
  
    <tr class="listaClara">
      <td colspan="7" bgcolor="#FFFFFF"><div id="divLista"></div></td>
  </tr>
    <tr class="listaClara">
        <td colspan="7" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
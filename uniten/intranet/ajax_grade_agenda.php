<?php
date_default_timezone_set('America/Sao_Paulo');
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();
$user = unserialize($_SESSION['USER']);
$diarioDao = new DiarioClasse();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$cargaHorariaTotal = Curso::staticGet($agenda->curso->id)->cargaHorariaTotal();

$inicio = DateTime::createFromFormat('H:i', $agenda->horarioInicial);
$fim = DateTime::createFromFormat('H:i', $agenda->horarioFinal);
$intervalo = $inicio->diff($fim);
$horas = $intervalo->format('%H');
$aulas = (int) $cargaHorariaTotal / $horas;



$msg = false;

if (!empty($_REQUEST['disciplina']) && !empty($_REQUEST['data'])) {
    $agenda = new AgendaCurso();
    $agenda->get($_SESSION['CODAGENDA']);
    $agendaInicio = strtotime($agenda->dataInicio . ' 00:00');
    $agendaTermino = strtotime($agenda->dataTermino . ' 23:59');
    $data = strtotime(data_us($_REQUEST['data']));

    $diarioDao->agenda = $_SESSION['CODAGENDA'];
   // if ($diarioDao->find(true) < $aulas) {

        if ($data >= $agendaInicio || $data <= $agendaTermino) {
            $diarioDao->reset();
            $diarioDao->agenda = $_SESSION['CODAGENDA'];
           // $diarioDao->professor = $_REQUEST['professor'];
            $diarioDao->disciplina = $_REQUEST['disciplina'];
            $diarioDao->data = $_REQUEST['data'];
            if ($diarioDao->find(true) === 0) {
                $diarioDao->save();
            } else {
                $msg = "ERRO: Já existe uma grade(diário) lançado nessa data.";
            }
        } else {
            $msg = "ERRO: A data informada está fora do período de aula da agenda";
        }
        logDao::gravaLog($user->login, 'ajax_grade_agenda', 'Gravou: diario de classe', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA'] . ' Data: ' . $_REQUEST['data']);
   // }else{
   //     $msg = "ERRO: Número de aulas excedido(".$aulas.")";
   // }
}

$diarioDao->reset();
$diarioDao->agenda = $_SESSION['CODAGENDA'];
$diarioDao->order('data desc')->find();
?>
<script>
    $( "#tbGrade tr:even" ).css( "background-color", "#A9D6F5" );
    $( "#tbGrade tr:odd" ).css( "background-color", "#ACE6CB" )

</script>
<link href="intranet.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" id="tbGrade">
<?php if ($msg != false) { ?>
        <tr>
            <td colspan="5"  bgcolor="#FF0000" align="center"><font color="#FFFFFF"><?php echo $msg ?></font></td>
        </tr>
<?php } ?>
    <tr>
       
        <td bgcolor="#CCCCCC">Data</td>
        <td bgcolor="#CCCCCC">Disciplina</td>
        <td bgcolor="#CCCCCC">Professor</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
<?php
$aData = array();
$i = $aulas;
while ($diarioDao->fetch()) {
    $professor = Professor::staticGet($diarioDao->professor)->nome;
    $disciplina = Disciplina::staticGet($diarioDao->disciplina)->nome;
    ?>
        <tr id="linha<?php echo $diarioDao->id ?>">
            
            <td><?php echo data_br($diarioDao->data) ?></td>
            <td><?php echo !empty($disciplina)? $disciplina:'Não informado' ?></td>
            <td ><?php echo $professor ?></td>


            <td align="center"><a href="javascript:;" id="<?php echo $diarioDao->id ?>" class="cssRemove">Remover</a></td>
        </tr>
<?php $i--; } ?>
   

</table>
<p align="center"><input name="btnImprimir" type="button" value="Imprimir" onclick="print();" /></p>

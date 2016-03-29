<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
require_once '../dao/agendaDisciplinaProfessorDao.php';
Security::cursoSecurity();
$agendaDao = new AgendaCursoDao();

$codAgenda = $agendaDao->escape((int) $_REQUEST['agenda']);



$alunos = $agendaDao->listaAlunoAgenda($codAgenda);



$agenda = new AgendaCurso();
$agenda->get($codAgenda);



$user = unserialize($_SESSION['USER']);

if ((int) $user->tipoLogin === 2) {

    $professorAgendaDao = new AgendaDisciplinaProfessorDao();

    if ($professorAgendaDao->getDisciplinaPorAgendaProfessor($codAgenda, $user->professor) === false) {
        $_REQUEST['ERRO'] = 'ACESSO NEGADO';
        logDao::gravaLog($user->login, 'alunosMatriculados', 'ERRO(1058) :: Agenda de outro professor', $_REQUEST,'','Agenda: '.$_REQUEST['agenda']);
        die('ERRO(1058) :: ACESSO NEGADO');
    }
}else{
  
    if((int)$user->empresa->id !== (int)$agenda->empresaCurso){
        $_REQUEST['ERRO'] = 'ACESSO NEGADO - COODENADOR';
        logDao::gravaLog($user->login, 'alunosMatriculados', 'ERRO(1058) :: Agenda de outra empresa', $_REQUEST,'','Agenda: '.$_REQUEST['agenda']);
        die('ERRO(1058) :: ACESSO NEGADO'); 
    }
}

logDao::gravaLog($user->login, 'alunosMatriculados', 'Acessou: lista de alunos ', $_REQUEST,'','Agenda: '.$_REQUEST['agenda']);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../intranet.css" rel="stylesheet" type="text/css">
<script src="../js/jquery-1.5.min.js" type="text/javascript"></script>
<script src="scripts/alunosMatriculados.js" type="text/javascript"></script>
<p><span class="titulo">Alunos</span><br />
    <br>
    Curso: <?php echo $agenda->curso->nome ?><br />
    Data: <?php echo data_br($agenda->dataInicio) ?><br />
    Alunos: <?php echo count($alunos) ?><br />
    <a href="xls_alunos.php?agenda=<?php echo $_REQUEST['agenda'] ?>" target="_blank"></a></p>
<table width="100%" cellpadding="3" cellspacing="1" class="lista">
    <tr class="listaClara">
        <td colspan="6"><table width="100%" border="0">
                <tr>
                    <td width="77%"><a href="xls_alunos.php?agenda=<?php echo $_REQUEST['agenda'] ?>" target="_blank">Exportar para Excel</a><a href="xls_alunos.php?agenda=<?php echo $_REQUEST['agenda'] ?>" target="_blank"></a></td>
                    <td width="23%"><?php if (count($alunos) > 0) { ?>
                            <a href="xls_relatorio-classe.php?agenda=<?php echo $_REQUEST['agenda'] ?>" target="_blank">Emitir relatório de frequência</a>
                        <?php } ?></td>
                </tr>
            </table></td>
    </tr>
    <tr class="listaClara">

        <td><strong>Nome</strong></td>
        <td><strong>Email</strong></td>
        <td><strong>Telefone</strong></td>
        <td><strong>Endereço</strong></td>
        <td><strong>Bairro</strong></td>
        <td width="162" align="center"><strong>Cidade</strong></td>
    </tr>
    <?php
    foreach ($alunos as $aluno) {
        ?>
        <tr class="listaClara" style="text-transform:uppercase">

            <td width="221"><a href="aluno.php?cod=<?php echo $aluno->id ?>"><?php echo $aluno->aluno ?></a></td>
            <td width="189"><?php echo $aluno->email ?></td>
            <td width="187"><?php echo $aluno->telefone ?></td>
            <td width="147"><?php echo $aluno->endereco ?> <?php echo $aluno->numero ?></td>
            <td width="118"><?php echo $aluno->bairro ?></td>
            <td align="center"><?php echo $aluno->cidade ?></td>
        </tr>
<?php } ?>
</table>
<p><a href="javascript:;" onclick="print();">imprimir</a></p>
<?php

require_once 'util/config.php';
Security::admSecurity();
require_once 'dao/agendaCursoDao.php';
$agendaDao = new AgendaCursoDao();

if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :


            $obj = new Aluno();

            if ($obj->get('cpf',@$_POST ['cpf']) == 0) {
                unset($_POST ['id']);
            }
            $obj->_setFrom($_POST);
            $obj->save();

            $status = $_POST['status_agenda'];

            $agenda = $_SESSION['CODAGENDA'];
            $aluno = $obj->id;

            if ($status === 4 && $_POST['desistencia'] === 1) {
                $desistencia = new Desistencia();
                $desistencia->aluno = $aluno;
                $desistencia->agenda = $agenda;
                $desistencia->motivo = $_POST['motivo'];
                $desistencia->save();
            }





            if (!empty($_POST['nota'])) {
                $nota = str_replace(',', '.', $agendaDao->escape($_POST['nota']));
            } else {
                $nota = 0;
            }

            if (!empty($_POST['classificacao'])) {
                $classificacao = $agendaDao->escape($_POST['classificacao']);
            } else {
                $classificacao = 0;
            }
            
            $passe = $agendaDao->escape($_POST['passe']);


            if ($_POST ['op'] == 'insert') {
                $agendaDao->gravaAlunoAgenda($agenda, $aluno, $status,$passe,$classificacao, $nota);
            } else {
                $agendaDao->alteraStatus($agenda, $aluno, $status);
                $agendaDao->alteraPasse($agenda, $aluno, $passe);
                if (!empty($_POST['classificacao'])) {
                    $agendaDao->alteraClassificacao($agenda, $aluno, $agendaDao->escape($_POST['classificacao']));
                }
                if (!empty($_POST['nota'])) {
                    $agendaDao->alteraNota($agenda, $aluno, str_replace(',', '.', $agendaDao->escape($_POST['nota'])));
                }
                
                
                
            }



            msg('Aluno inserido com sucesso!');
            gotox('candidatos.php?agenda=' . $agenda);

            break;

        case 'remover' :

            $agendaDao->removeAlunoCurso($_SESSION['CODAGENDA'], $agendaDao->escape($_REQUEST['aluno']));
            msg('Aluno removido da agenda com sucesso!');
            gotox('candidatos.php?agenda=' . $_SESSION['CODAGENDA']);
    }
}
?>

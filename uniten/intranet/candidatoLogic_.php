<?php

require_once 'util/config.php';
Security::admSecurity();
require_once 'dao/agendaCursoDao.php';
require_once '../application/libraries/Emailmanager.php';
$agendaDao = new AgendaCursoDao();
$user = unserialize($_SESSION['USER']);
if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :


            $obj = new Aluno();

            $alter = false;

            if ($obj->get('cpf', @$_POST ['cpf']) == 0) {
                unset($_POST ['id']);
                $alter = true;
            }
            $obj->_setFrom($_POST);
            $obj->save();

            $status = $_POST['status_agenda'];


            $agenda = $_SESSION['CODAGENDA'];
            $aluno = $obj->id;



            if ((int) $status === 1) {
                $agendaDao->gravaMatricula($_SESSION['CODAGENDA'], $aluno, $user->id);
            }




            if ((int) $status === 4 && (int) $_POST['desistencia'] === 1) {
                $desistencia = new Desistencia();
                if (!empty($_POST['desistenciaId'])) {
                    $desistencia->get($_POST['desistenciaId']);
                }
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
                $msg = 'Aluno cadastrado com sucesso';
                $objAgenda = new AgendaCurso();
                $objAgenda->get($agenda);
                $objAgenda->dataInicio = data_br($objAgenda->dataInicio);
                $objAgenda->dataTermino = data_br($objAgenda->dataTermino);
                if ((int) $objAgenda->prova === 1) {
                    $objAgenda->provaData = data_br($objAgenda->provaData);
                }


                $email = new Emailmanager();
                $email->enviaEmailInscricaoProva($objAgenda->toArray(), $obj->toArray());

                $agendaDao->gravaAlunoAgenda($agenda, $aluno, $status, $passe, $classificacao, $nota);

                logDao::gravaLog($user->login, 'candidatoLogic', 'Gravou: candidato na agenda', $_REQUEST, '', 'Agenda: ' . $agenda . ' Candidato: ' . $aluno);
            } else {
                // verificando se o usuario tem desistencia cadastrada.
                if ((int) $status !== 4) {
                    $objDesistencia = new Desistencia();
                    $count = (int) $objDesistencia->alias('d')->where('d.agenda=? and d.aluno = ?', $agenda, $aluno)->find(true);
                    if ($count > 0) {
                        msg('ERRO: Não foi possível alterar o status desse aluno no curso, pois existe um ficha de desistência cadastrada para o aluno nesse no curso. Remova a ficha de desistência e tente novamente.');
                        gotox('candidatoFormulario.php?id='.$aluno);
                        die;
                    }
                }

                $agendaDao->alteraStatus($agenda, $aluno, $status);
                $agendaDao->alteraPasse($agenda, $aluno, $passe);
                if (!empty($_POST['classificacao'])) {
                    $agendaDao->alteraClassificacao($agenda, $aluno, $agendaDao->escape($_POST['classificacao']));
                }
                if (!empty($_POST['nota'])) {
                    $agendaDao->alteraNota($agenda, $aluno, str_replace(',', '.', $agendaDao->escape($_POST['nota'])));
                }
                $msg = 'Aluno alterado com sucesso!';
                logDao::gravaLog($user->login, 'candidatoLogic', 'Alterou: candidato na agenda', $_REQUEST, '', 'Agenda: ' . $agenda . ' Candidato: ' . $aluno);
            }




            msg($msg);
            gotox('candidatos.php?agenda=' . $agenda);

            break;

        case 'remover' :

            $agendaDao->removeAlunoCurso($_SESSION['CODAGENDA'], $agendaDao->escape($_REQUEST['aluno']));
            msg('Aluno removido da agenda com sucesso!');


            logDao::gravaLog($user->login, 'candidatoLogic', 'Removeu: candidato da agenda', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA'] . ' Candidato: ' . $_REQUEST['aluno']);

            gotox('candidatos.php?agenda=' . $_SESSION['CODAGENDA']);
    }
}
?>

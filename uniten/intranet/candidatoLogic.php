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

            $errors = array();
            $obj = new Aluno();
            $agenda = $_SESSION['CODAGENDA'];
            $alter = false;

            if ($obj->get('cpf', $_POST ['cpf']) == 0) {
                unset($_POST ['id']);
                $alter = true;
            }
            /*             * * validando campos importantes */
           
            
            if(strlen($_REQUEST['nome'])<3){
                $errors[0] = 'O nome do aluno precisa ter mais que 2 caracteres';
            }
            
            if (empty($_REQUEST['cpf'])) {
                $errors[0] = 'Preencha o campo cpf';
            }
            
            if (empty($_REQUEST['rg'])) {
                $errors[0] = 'Preencha o campo RG';
            }
           

            if (count($errors) > 0) {
                logDao::gravaLog($user->login, 'candidatoLogic', 'Dados importantes: informações importantes não preenchidas', $_REQUEST, '', 'Agenda: ' . $agenda );
                msg('ERRO: Não foi possível cadastrar esse aluno devido ao seguinte erro: '.$errors[0]);
                gotox('candidatoFormulario.php?id='.@$_REQUEST['id'].'&cpf='.$_REQUEST['cpf']);
                die;
            }

          
            //xdebug();
            
           // $obj->get('cpf',$_REQUEST['cpf']);
            $obj->_setFrom($_POST);
            $obj->nome = $obj->escape($obj->nome);
            $obj->endereco = $obj->escape($obj->endereco);
            $obj->bairro = $obj->escape($obj->bairro);
            $obj->cidade = $obj->escape($obj->cidade);
            $obj->save();
            

            $status = $_POST['status_agenda'];


            
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
                        gotox('candidatoFormulario.php?id=' . $aluno);
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

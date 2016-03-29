<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
Security::provaSecurity();

$agendaDao = new AgendaCursoDao();
$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);




if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :

            $codAluno = $agendaDao->escape($_POST['aluno']);
            $aluno = $agendaDao->getAgendaAluno($_SESSION['CODAGENDA'], $codAluno);
            
            $nota = converteMoedaFloat($agenda->escape($_POST['notaProva']));
            $classificacao = $agenda->escape($_POST['classificacao']);
           
            
            if ($aluno != FALSE) {
                // verificando se eh inclusao ou alteracao
                if (empty($_POST['id'])) {
                    // verificando se não existe nenhum aluno com a classificao informada

                    if ($agendaDao->verificaAlunoClassificacao($_SESSION['CODAGENDA'], $classificacao) == 0) {
                       
                        $agendaDao->alteraClassificacao($_SESSION['CODAGENDA'], $codAluno, $classificacao,$nota);
                        if ((int) $_POST['classificacao'] <= (int) $agenda->vagas) {
                            // desabilitado para controle do adm 17/05 
                            // $agendaDao->alteraStatus($_SESSION['CODAGENDA'], $codAluno, 1);
                        }
                        msg('OK: Classificação inserida com sucesso!');
                        gotox('candidatos.php');
                    } else {
                        msg('ERRO: Já existe um candidato cadastrado com essa classificação!');
                        gotox('classificacaoCadastro.php?aluno=' . $codAluno);
                    }
                } else {
                    $idRet = $agendaDao->verificaAlunoClassificacao($_SESSION['CODAGENDA'], $classificacao);
                    if ($idRet == $codAluno) {
                        $agendaDao->alteraClassificacao($_SESSION['CODAGENDA'], $codAluno, $classificacao,$nota);
                        if ((int) $_POST['classificacao'] <= (int) $agenda->vagas) {
                            // desabilitado para controle do adm 17/05 
                            //$agendaDao->alteraStatus($_SESSION['CODAGENDA'], $codAluno, 1);
                        }
                    } else {
                        msg('ERRO: Não foi possivel realizar a ação!');
                        gotox('candidatos.php');
                    }
                }
            } else {
                msg('ERRO: Não foi possivel realizar a ação!');
                gotox('candidatos.php');
            }
            break;

        case 'desclassificar' :
          
            $agendaDao->alteraClassificacao($_SESSION['CODAGENDA'], $agendaDao->escape($_REQUEST['aluno']), 0,0);
            $agendaDao->alteraStatus($_SESSION['CODAGENDA'], $agendaDao->escape($_REQUEST['aluno']), 0);
            //msg('OK: Ação realizada com sucesso!');
            gotox('candidatos.php');

            break;
    }
}


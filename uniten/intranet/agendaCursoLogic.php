<?php

require_once 'dao/feriadoDao.php';
require_once 'util/config.php';
Security::admSecurity();

$obj = new AgendaCurso();
$user = unserialize($_SESSION['USER']);



if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);
                $op = 1;
                $msgLog = "Gravou: nova agenda";
            } else {
                $op = 2;
                $_POST['dataAtualizacao'] = time();
                $msgLog = "Alterou:  agenda";
            }
            try {
                $obj->setFrom($_POST);
                if (!empty($_POST['valorVale'])) {
                    $obj->valorVale = converteMoedaFloat($_POST['valorVale']);
                }
                $obj->valor = converteMoedaFloat($_POST['valor']);
                $obj->save();

                logDao::gravaLog($user->login, 'agendaCursoLogic', $msgLog, $_REQUEST, '', 'Agenda: ' . $obj->id);




                // ser for inserção grava as agendas automaticamente
                if (isset($_POST['gerarAgendas'])) {
                    //$ret = getHTTP(BASEURL . '/intranet/gera_diarios.php?agenda=' . $obj->id . "&op=" . $op);
                    geraDiarios($obj->id, $op);
                }


                gotox("principal.php?acao=agendaCursoMensagem&agenda=" . $obj->id . "&op=" . $op);





                /* msg($msg);
                  if (!empty($_SESSION['LOCAL'])) {
                  gotox("principal.php?acao=".$_SESSION['ORIGEM']."&local=" . $_SESSION['LOCAL']."&offset=".$_SESSION['OFFSET']);
                  } elseif (!empty($_SESSION['BUSCA'])) {
                  gotox("principal.php?acao=".$_SESSION['ORIGEM']."&busca=" . $_SESSION['BUSCA']."&offset=".$_SESSION['OFFSET']);
                  } else {
                  gotox("principal.php?acao=".$_SESSION['ORIGEM']."&offset=".$_SESSION['OFFSET']);
                  } */
            } catch (Exception $exc) {
                logDao::gravaLog($user->login, 'agendaCursoLogic', 'ERRO(gravar)', $_REQUEST, $exc);
                msg('ERRO: Não foi possível cadastrar esse agenda');
                gotox("principal.php?acao=" . $_SESSION['ORIGEM']);
            }

            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    // ferificanco se e o admin
                    if ($user->local != 1) {

                        // verificando se o usuario e do mesmo local do curso
                        if ($obj->local->id != $user->local) {
                            msg('ERRO: Você não tem permissão para remover essa agenda');
                            gotox('principal.php?acao=agendacursos');
                        }
                    }

                    $obj->_getConnection()->executeSQL('delete from diario_classe where local_curso_id = ' . $_GET ['id']);
                    $obj->delete();
                    logDao::gravaLog($user->login, 'agendaCursoLogic', 'Removeu: agenda', $_REQUEST, '', 'Agenda: ' . $_GET ['id']);
                    msg('OK: Agenda removida com sucesso!');
                    gotox("principal.php?acao=agendacursos");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'agendaCursoLogic', 'ERRO(remover)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível remover essa Agenda devido à informações vinculadas a ela \r\n Utilize a opção de desativar');
                    gotox("principal.php?acao=agendacursos");
                }
            }
            break;
        case 'ativacao' :

            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {


                    $obj->_getConnection()->executeSQL("UPDATE local_curso SET ativo = " . $_REQUEST['ativo'] . " WHERE id=" . $_REQUEST['id']);
                    logDao::gravaLog($user->login, 'agendaCursoLogic', 'Alterou: status da ativacao', $_REQUEST, '', 'Agenda: ' . $_GET ['id'] . ' Status: ' . $_REQUEST['ativo']);

                    if (!empty($_SESSION['LOCAL'])) {
                        gotox("principal.php?acao=agendacursos&local=" . $_SESSION['LOCAL'] . "&offset=" . $_REQUEST['offset']);
                    } elseif (!empty($_SESSION['BUSCA'])) {
                        gotox("principal.php?acao=agendacursos&busca=" . $_SESSION['BUSCA'] . "&offset=" . $_REQUEST['offset']);
                    } else {
                        gotox("principal.php?acao=agendacursos&offset=" . $_REQUEST['offset']);
                    }
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'agendaCursoLogic', 'ERRO(ativacao)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível desativar essa Agenda');
                    gotox("principal.php?acao=agendacursos");
                }
            }
            break;

        case 'resultado' :

            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {

                    $termininoInscri = strtotime($obj->dataFinalInscricao);
                    $dataatual = strtotime(date("Y-m-d"));

                    if ($termininoInscri > $dataatual) {
                        msg('ATENÇÃO: Não é possível publicar o resultado do curso, porque as inscrições ainda estão abertas');
                        gotox("principal.php?acao=agendacursos");
                    }

                    $rs = $obj->_getConnection()->executeSQL("select count(*) as total, (select count(*)  from local_curso_aluno where local_curso_id = " . $_REQUEST['id'] . " and (classificacao <> '' or classificacao <> 0)) as classificado  from local_curso_aluno where local_curso_id =  " . $_REQUEST['id']);
                    $row = mysql_fetch_array($rs);

                    if ($row['total'] == 0) {
                        logDao::gravaLog($user->login, 'agendaCursoLogic', 'ERRO: nao conseguiu  publicar o resultado da agenda', $_REQUEST, '', 'Agenda: ' . $_GET ['id']);

                        msg('ATENÇÃO: Não existem candidatos cadastrados nesse curso!');
                        gotox("principal.php?acao=agendacursos");
                    } /* elseif ($row['total'] != $row['classificado']) {
                      msg('ATENÇÃO: Não foi possível publicar essa agenda, porque nem todos os candidatos estão classificados ainda');
                      gotox("principal.php?acao=agendacursos");
                      } */ else {
                        $obj->_getConnection()->executeSQL("UPDATE local_curso SET resultado = " . $_REQUEST['resultado'] . " WHERE id=" . $_REQUEST['id']);
                        logDao::gravaLog($user->login, 'agendaCursoLogic', 'Alterou: resultado para publicado', $_REQUEST, '', 'Agenda: ' . $_GET ['id']);

                        if (!empty($_SESSION['LOCAL'])) {
                            gotox("principal.php?acao=agendacursos&local=" . $_SESSION['LOCAL'] . "&offset=" . $_REQUEST['offset']);
                        } elseif (!empty($_SESSION['BUSCA'])) {
                            gotox("principal.php?acao=agendacursos&busca=" . $_SESSION['BUSCA'] . "&offset=" . $_REQUEST['offset']);
                        } else {
                            gotox("principal.php?acao=agendacursos" . "&offset=" . $_REQUEST['offset']);
                        }
                    }
                } catch (Exception $exc) {
                    logDao::gravaLog($user->login, 'agendaCursoLogic', 'ERRO(resultado)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível ativar o resultado essa Agenda');
                    gotox("principal.php?acao=agendacursos");
                }
            }
            break;
    }
}

function geraDiarios($agenda,$op) {
    $daoFeriado = new FeriadoDao();
   // verificando se uma chamada para alteração de agenda
    if ((int)$op === 2) {

        //verifica se a agenda tem registro de atividades
        $sql = "select count(0) as total from diario_classe where local_curso_id = {$agenda} and id in (select diario_classe_id from diario_classe_aluno)";
        $rs = AgendaCurso::staticGet($agenda)->_getConnection()->executeSQL($sql);
        $row = mysql_fetch_array($rs);

        if ((int) $row['total'] === 0) {
            // se não tiver atividade remove para recriar os diarios
            AgendaCurso::staticGet($agenda)->_getConnection()->executeSQL("delete from diario_classe where local_curso_id = {$agenda}");
        }
    }

    $totalDisciplina = count(AgendaCurso::staticGet($agenda)->curso->disciplinas);
    $dateStart = AgendaCurso::staticGet($agenda)->dataInicio;
    $dateEnd = AgendaCurso::staticGet($agenda)->dataTermino;

//Star date
    $dateStart = new DateTime($dateStart);
//End date
    $dateEnd = new DateTime($dateEnd);


    $idD = NULL;

    if ($totalDisciplina === 1) {
        $disciplina = AgendaCurso::staticGet($agenda)->curso->disciplinas[0];
        $idD = $disciplina->id;
    }



//Prints days according to the interval
    $dateRange = array();
    while ($dateStart <= $dateEnd) {
        //$dateRange[] = $dateStart->format('Y-m-d');
        $data = $dateStart->format('Y-m-d');

        if ($daoFeriado->isFeriado($data) <= 0 && isDiaUtil($data) === true) {
            $sql = "select id from diario_classe where local_curso_id = {$agenda} and data_aula = '{$data}'";
            $rs = AgendaCurso::staticGet($agenda)->_getConnection()->executeSQL($sql);
            if (mysql_num_rows($rs) === 0) {
                $sql = "INSERT INTO diario_classe(local_curso_id,disciplina_id,data_aula) VALUES('{$agenda}','{$idD}','{$data}')";
                AgendaCurso::staticGet($agenda)->_getConnection()->executeSQL($sql);
            }
        }
        $dateStart = $dateStart->modify('+1day');
    }


}

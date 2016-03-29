<?php

require_once '../util/config.php';
require_once '../dao/diarioClasseDao.php';
require_once '../dao/agendaCursoDao.php';
Security::cursoSecurity();
$obj = new DiarioClasse();
$user = unserialize($_SESSION['USER']);



validaCampos($_POST);


if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :

            $obj->get($_POST['id']);
            $obj->_setFrom($_POST);
            $obj->agenda = $_SESSION['CODAGENDA'];
            $obj->save();




            $cod = $_SESSION['CODAGENDA'];
            $diario = $obj->id;

            /*             * ** inserindo as presencas *** */
            // removendo varias que nao sao nescessarias
            unset($_POST['acao']);
            unset($_POST['disciplina']);
            unset($_POST['id']);
            unset($_POST['datahoje']);
            unset($_POST['professor']);
            unset($_POST['data']);
            unset($_POST['horas']);
            unset($_POST['conteudo']);

            foreach ($_POST as $key => $value) {

                $aDado = explode('-', $key);
                if (!empty($aDado[1])) {



                    $diarioDao = new DiarioClasseDao();
                    $aluno = $aDado[1];
                    $diarioDao->alteraPresenca($diario, $aluno, $value);


                    if ((int) $value === 1) {
                        $agendaDao = new AgendaCursoDao();
                        $vale = $agendaDao->getPasse($_SESSION['CODAGENDA'], $aluno);

                        if ($vale == NULL) {
                            $vale = 0;
                        }


                        $diarioDao->alteraVale($diario, $aluno, $vale);
                    } else {
                        $diarioDao->alteraVale($diario, $aluno, 0);
                    }
                }
                //var_dump($aDado[1]);
            }



            logDao::gravaLog($user->login, 'diarioLogic', $_REQUEST ['acao'] . 'Alterou : diario de classe', $_REQUEST, '', 'Diario: ' . $obj->id);

            msg("OK: Diário de classe gravado com sucesso!");
            gotox("principal.php?acao=diarioVisualizar&id=" . $diario);


            break;

        // nao esta sendo utilizado
        case 'gravapresenca' :

            $cod = @$_SESSION['CODAGENDA'];
            $diario = $_REQUEST['diario'];

            foreach ($_POST as $key => $value) {

                $aDado = explode('-', $key);
                if (!empty($aDado[1])) {



                    $diarioDao = new DiarioClasseDao();
                    $aluno = $aDado[1];
                    $diarioDao->alteraPresenca($diario, $aluno, $value);


                    if ((int) $value === 1) {
                        $agendaDao = new AgendaCursoDao();
                        $vale = $agendaDao->getPasse($_SESSION['CODAGENDA'], $aluno);

                        if ($vale == NULL) {
                            $vale = 0;
                        }


                        $diarioDao->alteraVale($diario, $aluno, $vale);
                    } else {
                        $diarioDao->alteraVale($diario, $aluno, 0);
                    }
                }
                //var_dump($aDado[1]);
            }
            $_SESSION['CODDIARIO'] = $obj->id;
            logDao::gravaLog($user->login, 'diarioLogic', $_REQUEST ['acao'], $_REQUEST);

            msg("OK: Diário de classe gravado com sucesso!");
            gotox("principal.php?acao=diarioVisualizar&id=" . $diario);
            break;
    }
}

function validaCampos($post) {
    unset($_SESSION['ERROS']);
    $erros = array();
    if (empty($post['disciplina'])) {
        $erros[] = 'Disciplina não informada';
    }

    if (empty($post['horas'])) {
        $erros[] = 'Horas utilizadas não informada';
    }

    if (empty($post['conteudo'])) {
        $erros[] = 'Conteudo não informada';
    }


    $total = (int) $post['totalAlunos'];

    unset($post['id']);
    unset($post['acao']);
    unset($post['totalAlunos']);
    unset($post['professor']);
    unset($post['disciplina']);
    unset($post['data']);
    unset($post['horas']);
    unset($post['conteudo']);
    unset($post['Continuar']);

    if ($total !== count($post)) {
        $txt = '' . ($total - count($post)) . ' aluno(s) sem presença';
        $erros[] = $txt;
    }


    if (count($erros) != 0) {
        $_SESSION['ERROS'] = $erros;
        die('<script>history.go(-1);</script>');
    }
}

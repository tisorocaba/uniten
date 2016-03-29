<?php

require_once 'util/config.php';

Security::admSecurity();

require_once 'dao/agendaCursoDao.php';
require 'dao/diarioClasseDao.php';
$obj = new DiarioClasse();
$user = unserialize($_SESSION['USER']);

//xdebug();
if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);

                $obj->alias('d')->where('d.agenda=? and d.data = ?', $_SESSION['CODAGENDA'], data_us($_POST['data']))->find();

                if ($obj->count() > 0) {
                    msg("ERRO: Já existe um diário de classe cadastrado nesse dia!");
                    gotox("diarioCadastro.php");
                    die;
                }


                $agenda = new AgendaCurso();
                $agenda->get($_SESSION['CODAGENDA']);
                $inicio = strtotime($agenda->dataInicio);
                $termino = strtotime($agenda->dataTermino);
                $informada = strtotime(data_us($_POST['data']));
                $msgLog = "Gravou: novo diario";
            } else {
                $_REQUEST ['acao'] = 'Alteração';
                $msgLog = "Alterou:  diario";
            }


            $obj->_setFrom($_POST);
            $obj->agenda = $_SESSION['CODAGENDA'];



            $obj->save();
            $_SESSION['CODDIARIO'] = $obj->id;

            logDao::gravaLog($user->login, 'diarioLogic', $msgLog, $_REQUEST, '', 'Diario: ' . $obj->id);

            gotox("diarioAlunos.php");


            break;

        case 'remover' :
            if (!empty($_GET ['id']) && $obj->get($_GET ['id']) == 1) {
                try {
                    $obj->removeAll('alunos');
                    $obj->delete();
                    logDao::gravaLog($user->login, 'diarioLogic', 'Removeu: diario de classe', $_REQUEST, '', 'Diario: ' . $_GET ['id']);
                    gotox("diarios.php");
                } catch (Exception $exc) {
                    logDao::gravaLog($user->id, 'diarioLogic', 'ERRO(remover)', $_REQUEST, $exc);
                    msg('ATENÇÃO: Não foi possível remover esse diário devido à informações vinculadas a ele.');
                    gotox("diarios.php");
                }
            }
            break;

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
            
            logDao::gravaLog($user->login, 'diarioLogic', 'Gravou: presença no diario', $_REQUEST, '', 'Diario: ' . $diario);

            msg("OK: Diário de classe gravado com sucesso!");
            gotox("diarioVisualizar.php?id=" . $diario);
            break;
    }
}
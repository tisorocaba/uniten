<?php

require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';

Security::admSecurity();
$obj = new Aluno();
$cpf = limpaCPF($_POST ['cpf']);

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);



//$sub = date('d/m/Y', strtotime("-40 years",strtotime(data_us($_REQUEST['dataNascimento'])))); 

$datastart = strtotime("-80 years", strtotime(date('Y-m-d')));
$dataminima = strtotime("-" . $agenda->idade . " years", strtotime($agenda->dataInicio));
$datacandidato = strtotime(data_us($_REQUEST['dataNascimento']));



//$termininoInscri = strtotime($agenda['dataNascimento']);

if ($datacandidato < $datastart) {
    msg('ERRO: Por favor verifique a data de nascimento!');
    gotox("candidatoCadastro.php");
} elseif ($datacandidato > $dataminima) {
    msg('ERRO: O candidato não tem idade suficiente para participar do curso!');
    gotox("candidatoCadastro.php");
}



if (ValidateCPF::execute($cpf) === false) {
    msg('ERRO: CPF invalido!');
    gotox("candidatoCadastro.php");
}

// adicionando a data de nascimento na session para usar na ficha de cadatro
$_SESSION['DATANASCIMENTO'] = $_REQUEST['dataNascimento'];



if ($obj->get('cpf', $cpf) == 1) {
    $cursoDao = new AgendaCursoDao();
    // verificando se o aluno já e cadastrado
    if ($cursoDao->getAgendaAluno($_SESSION['CODAGENDA'], $obj->id) !== false) {
        msg('Este aluno já está cadastrado nesse curso!');
        gotox("candidatoCadastro.php");
    }

    $agendaDao = new AgendaCursoDao();

    /*     * **** Verificando se o aluno ja e cadastrado em algum curso dentro do periodo ****** */
    $oDado = $agendaDao->ultimoCurso($obj->id);



    // verificando se o ultimo curso nao esta finalizado
    if ($oDado != false) {



        if ($oDado->status == 0 || (int) $oDado->status === 1) {

            // verificando se o local do curso e eden ou unite central
            // alterado pelo Rogerio 23/09/13
            // if (((int) $oDado->local === 1 || (int) $oDado->local === 31) && (int) $oDado->prova === 1) {
            if ((int) $oDado->local === 1 || (int) $oDado->local === 31) {


                // data inicial e final do curso atual
                $dataInicioCursoAtual = strtotime($agenda->dataInicio);
                $dataFinalCursoAtual = strtotime($agenda->dataTermino);
                // data inicial e fianl do ultimo curso
                $dataTerminoUltimoCurso = @strtotime($oDado->data_final);
                $dataInicioUltimoCurso = @strtotime($oDado->data_inicio);


                // alterado pelo rogerio 22/01/14
                if ($dataInicioCursoAtual >= $dataInicioUltimoCurso && $dataInicioCursoAtual <= $dataTerminoUltimoCurso) {
                    //if ($oDado->periodo == $agenda->periodo) {
                        //msg('ATENÇÂO: Este aluno não poder ser cadastrado, pois o período da aula está coiencidindo com o curso atual \r\n ' . $oDado->nome);
                        gotox("candidatoCadastroForcado.php?aluno=".$obj->id."&curso=".$oDado->agenda);
                        die;
                    //}
                }

                if ($dataFinalCursoAtual >= $dataInicioUltimoCurso && $dataFinalCursoAtual <= $dataTerminoUltimoCurso) {
                    //if ($oDado->periodo == $agenda->periodo) {
                        //msg('ATENÇÂO: Este aluno não poder ser cadastrado, pois o período da aula está coiencidindo com o curso atual \r\n ' . $oDado->nome);
                        gotox("candidatoCadastroForcado.php?aluno=".$obj->id."&curso=".$oDado->agenda);
                        die;
                    //}
                }


                /* if ($dataTerminoUltimoCurso >= $dataInicioCursoAtual) {

                  if ($oDado->periodo == $agenda->periodo) {
                  msg('ATENÇÂO: Este aluno não poder ser cadastrado, pois o período da aula está coiencidindo com o curso atual \r\n ' . $oDado->nome);
                  gotox("candidatoCadastro.php");
                  }
                  } */
            }
        } elseif ((int) $oDado->status === 4) { /* else {
          $dataInicioAula = strtotime($obj->dataInicio);
          $dataTerminoUltimoCurso = @strtotime($oDado->data_final);



          if ($dataTerminoUltimoCurso >= $dataInicioAula) {


          // verificando a horario de inicio
          if ($oDado->periodo == $agenda->periodo) {
          msg('ATENÇÂO: Este aluno não poder ser cadastrado, pois os horários estão coiencidindo com os do curso atual ' . $oDado->nome);
          gotox("candidatoCadastro.php");
          }
          }
          } */
            // verificando se o aluno possui registro de desistencia
            $agendaDao = new AgendaCursoDao();
            $oDesistencia = $agendaDao->verificaDesistencia($obj->id);

            // verificando se eh desistente justificada
            if (count((array) $oDesistencia) > 0) {
                // existe  desistencia
                // verificando se foi justificada 
                if (empty($oDesistencia->desistencia)) {
                    //se jah passou o tempo de penalizacao
                    if ($oDesistencia->contador <= 360) {
                        msg('Este aluno está penalizado por desistência não justificada');
                        gotox("candidatoCadastro.php");
                    }
                }
            }
        }
    }
}









gotox("candidatoFormulario.php?id=" . $obj->id . "&cpf=" . $cpf . "&acao=insert");


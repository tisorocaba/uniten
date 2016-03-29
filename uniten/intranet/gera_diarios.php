<?php

require './dao/feriadoDao.php';
require_once 'util/config.php';



$daoFeriado = new FeriadoDao();
$agenda = $_REQUEST['agenda'];



$op = (int) $_REQUEST['op'];
// verificando se uma chamada para alteração de agenda
if ($op === 2) {

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



        //echo $sql. '<br>'; 
    }
    $dateStart = $dateStart->modify('+1day');
}



/* function isDiaUtil($data) {

    //Colocamos em um array os dia de fim de semana (sábado e domingo)
    $fds = array('6', '0');

    //Verificamos qual é o dia da semana
    $diaSemana = date('w', strtotime($data));

  
    //Aqui verficamos se é o dia útil
    if (in_array($diaSemana, $fds)) {

        return false;
    } else {

        return true;
    }
}
*/

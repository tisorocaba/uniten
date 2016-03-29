<?php
require './dao/feriadoDao.php';
require_once 'util/config.php';

$daoFeriado = new FeriadoDao();

var_dump(AgendaCurso::staticGet(715)->curso->disciplinas);

die;

$cursoDao = new Curso();
$cursoDao->get('224');

$idD = false;

if(count($cursoDao->disciplinas)===1){
 $disciplina = $cursoDao->disciplinas[0];
 $idD =  $disciplina->id;
}






//Star date
$dateStart = '10/06/2014';
$dateStart = implode('-', array_reverse(explode('/', substr($dateStart, 0, 10)))) . substr($dateStart, 10);
var_dump($dateStart);
die;
$dateStart = new DateTime($dateStart);

//End date
$dateEnd = '30/06/2014';
$dateEnd = implode('-', array_reverse(explode('/', substr($dateEnd, 0, 10)))) . substr($dateEnd, 10);
$dateEnd = new DateTime($dateEnd);

//Prints days according to the interval
$dateRange = array();
while ($dateStart <= $dateEnd) {
    //$dateRange[] = $dateStart->format('Y-m-d');
    $data = $dateStart->format('Y-m-d');
   
    if( $daoFeriado->isFeriado($data) > 0 || isDiaUtil($data)===false){
        echo $data . 'Não e valida <br>'; 
    }else{
        echo $data . 'E valida <br>'; 
    }
    $dateStart = $dateStart->modify('+1day');
}

function isDiaUtil($data) {

    //Colocamos em um array os dia de fim de semana (sábado e domingo)
    $fds = array('6', '0');

    //Verificamos qual é o dia da semana
    $diaSemana = date('w', strtotime($data));

    echo $diaSemana;
  
    //Aqui verficamos se é o dia útil
    if (in_array($diaSemana, $fds)) {

        return false;
    } else {

        return true;
    }
}


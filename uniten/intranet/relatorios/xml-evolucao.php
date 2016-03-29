<?php

require_once "../util/config.php";
require_once '../dao/agendaCursoDao.php';
$agendaDao = new AgendaCursoDao();
$anos = $_SESSION['ANOS'];


$contCat = '';
foreach ($anos as $ano) {
    $contCat .= '<category name="'.$ano.'"/>';
}

$dataC = '';
foreach ($anos as $ano) {
    $dataC .= '<set value="'.$agendaDao->agendaDadosEvolucao($ano, 'C').'"/>';
    
}

$dataV = '';
foreach ($anos as $ano) {
    $dataV .= '<set value="'.$agendaDao->agendaDadosEvolucao($ano, 'V').'"/>';
    
}

$dataN = '';
foreach ($anos as $ano) {
    $dataN .= '<set value="'.$agendaDao->agendaDadosEvolucao($ano, 'N').'"/>';
    
}

$dataD = '';
foreach ($anos as $ano) {
    $dataD .= '<set value="'.$agendaDao->agendaDadosEvolucao($ano, 'D').'"/>';
    
}


$xml = '<graph  caption="UNITE" 
                shownames="1" 
                showvalues="1" 
                numberPrefix="" 
				formatNumber="0" 
				formatNumberScale="0"
				decimalSeparator=","  
				thousandSeparator="."
                bgColor="E4E7D9" 
                bgAlpha="40" 
                showAlternateHGridColor="1" 
                AlternateHGridAlpha="30" 
                AlternateHGridColor="E4E7D9" 
                divLineColor="E4E7D9" 
                divLineAlpha="80" 
                canvasBorderThickness="1" 
                canvasBorderColor="114B78" 
                limitsDecimalPrecision="0" 
                divLineDecimalPrecision="0" 
                decimalPrecision="0">
 <categories>
       '.$contCat.'
       
</categories>

<dataset seriesName="Cursos Concluidos" color="FF0000">
       '.$dataC.' 
       
</dataset>

<dataset seriesName="Vagas Ofertadas" color="FFFF00">
        '.$dataV.' 
        
</dataset>

<dataset seriesName="Numero de Formados" color="0000FF">
       '.$dataN.' 
      
</dataset>

<dataset seriesName="Demanda por cursos" color="8BBA00">
        '.$dataD.' 
       
</dataset>

</graph>';

echo'<?xml version="1.0" encoding="UTF-8" ?>';
echo $xml;
unset($_SESSION['ANOS']); 
?>
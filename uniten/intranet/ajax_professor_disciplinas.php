<?php
require_once 'util/config.php';
require_once 'dao/agendaDisciplinaProfessorDao.php';

if ($_REQUEST['professor'] != 0) {
    $agendaDao = new AgendaDisciplinaProfessorDao();
    $disciplinas = $agendaDao->getDisciplinaPorAgendaProfessor($_SESSION['CODAGENDA'], $_REQUEST['professor']);
 
    echo '<select name="disciplina" id="disciplina" class="validate[required]" > ';
        echo '<option value="" >Selecione...</option>';
    foreach ($disciplinas as $disciplina) {
          
           if ($disciplina->disid == @$_REQUEST['disciplina']) {
                echo '<option value="' . $disciplina->disid . '" selected>' . $disciplina->disciplina . '</option>';
            } else {
                echo '<option value="' . $disciplina->disid . '">' . $disciplina->disciplina . '</option>';
            }
    }
    
    echo '</select>*';
}       
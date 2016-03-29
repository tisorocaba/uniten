<?php
require_once 'util/config.php';
Security::admSecurity();
if (empty($_REQUEST['professor'])) {
 
    $disciplina = new Disciplina();
    $disciplina->alias('d')->where('d.curso=?', $_REQUEST['curso'])->order('nome ASC')->find();

    
    while ($disciplina->fetch()) {
        printf('<input type="checkbox" name="disciplinas[]" class="validate[required]" id="disciplinas" value="%d" %s  /> %s <br />',
                $disciplina->id,
                !empty($_POST['disciplinas']) && in_array($disciplina->id, $_POST['disciplinas']) ? 'checked="checked"' : '',
                $disciplina->nome);
        
    }
} else {

    $professor = new Professor();
    $professor->get($_REQUEST['professor']);

    $disciplina = new Disciplina();
    $disciplina->alias('d')->where('d.curso=?', $_REQUEST['curso'])->order('nome ASC')->find();

     while ($disciplina->fetch()) {
        printf('<input type="checkbox" name="disciplinas[]" class="validate[required]" id="disciplinas" value="%d" %s  /> %s <br />',
                $disciplina->id,
                !empty($_POST['disciplinas']) && in_array($disciplina->id, $professor->getLink('disciplinas')) ? 'checked="checked"' : '',
                $disciplina->nome);

    }

    /* foreach ($professor->getLink('disciplinas') as $disciplina) {
        echo '<input type="checkbox" name="disciplinas[]" class="validate[required]" id="disciplinas" value="'.$disciplina->id.' checked="checked" /> ';
    } */

}

?>
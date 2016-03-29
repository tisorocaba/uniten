<?php
require_once 'util/config.php';
require_once 'dao/agendaDisciplinaProfessorDao.php';
Security::admSecurity();



if (!empty($_REQUEST['agenda'])) {
    $_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}

$monitoresDao = new AgendaDisciplinaProfessorDao();
$monitores = $monitoresDao->listaProfessorAgenda($_SESSION['CODAGENDA']);


$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);


$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'agendamonitores', 'Acessou: lista de monitores', $_REQUEST, '', 'Agenda: ' . $_SESSION['CODAGENDA']);

?>

<link href="intranet.css" rel="stylesheet" type="text/css">
<script src="../assets/js/jquery-1.5.1.min.js" type="text/javascript"></script>
<script src="scripts/agendamonitores.js" type="text/javascript"></script>
<p><span class="titulo">Monitores</span><br />
    <br>
    Curso: <?php echo $agenda->curso->nome ?><br />
</p>

<?php if (count($monitores) > 0 && empty($_REQUEST['acao'])) { ?>
    <table width="100%" cellpadding="1" cellspacing="1" class="lista">
        <tr class="listaClara">
            <td><strong>Disciplina</strong></td>
            <td><strong>Monitor</strong></td>
        </tr>
        <?php
        foreach ($monitores as $monitor) {
            ?>
            <tr class="listaClara">
                <td width="291"><?php echo $monitor->disciplina ?></td>
                <td width="349"><?php echo $monitor->professor ?></td>
            </tr>
        <?php } ?>
    </table>
    <p align="center"><input name="imprimir" value="imprimir" type="button" onclick="print();" /> <input name="alterar" value="alterar" type="button" onclick="self.location='agendamonitores.php?acao=alterar'" /></p>

<?php } else { ?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <?php    foreach (AgendaCurso::staticGet($_SESSION['CODAGENDA'])->curso->getLink('disciplinas') as $disciplina) {   ?>


            <tr>
                <td colspan="2"><strong><?php echo $disciplina->nome?></strong></td>
            </tr>
            <tr>
                <td colspan="2"><hr /></td>
            </tr>
            <?php 
            
            $sql = "SELECT
                      PD.professor_id as id,
                         (select nome from professor where id = PD.professor_id) as nome
                     FROM disciplina D, professor_disciplina PD  
                     WHERE D.id = ".$disciplina->id."
                     AND PD.disciplina_id = D.id 
                     AND PD.professor_id IN (select id from professor where empresa_id = ".AgendaCurso::staticGet($_SESSION['CODAGENDA'])->empresaCurso.")
           ";
            
            $rs = $agenda->_getConnection()->executeSQL($sql);
           
            while($professor = mysql_fetch_object($rs)){
            
                
                if($monitoresDao->verificaProfessorAgenda($_SESSION['CODAGENDA'], $professor->id,$disciplina->id)===true){
                      $checked = 'checked'; 
                }else{
                      $checked = ''; 
                }
                
                ?>
                <tr>
                    <td width="5%">
                        <input type="radio" name="radio<?php echo $disciplina->id?>" <?php echo @$checked?> id="radio" value="<?php echo $disciplina->id?>|<?php echo $professor->id?>" class="cssAlteraProfessorAgenda" />
                    </td>
                    <td width="95%"><?php echo $professor->nome?></td>
                </tr>
                
                 
                
            <?php } ?>
                
                <tr>
                    <td colspan="2">&nbsp;</td>
            </tr>

        <?php } ?>

    </table>
    
     <p align="center"> <input name="concluir" value="concluir" type="button" onclick="self.location='agendamonitores.php?acao='" /></p>

<?php } ?>

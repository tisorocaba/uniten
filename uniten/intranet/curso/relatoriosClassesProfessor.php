<?php
Security::cursoSecurity();
$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();
Security::cursoSecurity();



$professor = new Professor();
$sql = 'SELECT local_curso_id as id, 
       (SELECT nome From local_curso LC, curso C WHERE local_curso_id = LC.id and LC.curso_id = C.id ) as nome,  
       (SELECT local From local_curso LC, local L WHERE local_curso_id = LC.id and LC.local_id = L.id ) as local,  
       LCEX.data_inicio as dataInicio,
	   LCEX.data_termino as dataTermino,
       LCEX.horario_inicial,
       LCEX.horario_final
FROM  agenda_professor_disciplina APD, 
      local_curso LCEX 
WHERE professor_id = '.$user->professor.' AND local_curso_id = LCEX.id  AND  STATUS = 1  GROUP BY  local_curso_id';

$rs = $professor->_getConnection()->executeSQL($sql);




logDao::gravaLog($user->login, 'relatoriosClassesProfessor', 'Acessou: lista de relatorios de classe');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<p><span class="titulo">Relatórios de Classes</span><br>
    <br />
    </p>

<script src="scripts/relatoriosClassesProfessor.js"></script>
<table width="100%" cellpadding="3" cellspacing="1" class="lista" >
    <tr class="listaClara">
        <td colspan="12">&nbsp;</td>
    </tr>
    <!-- <tr class="listaClara">
        <td colspan="5"><strong>Pesquisa</strong>:
            <input name="busca" id="busca" type="text" value="<?php echo @$_REQUEST['busca']; ?>" />
            <input type="button" name="button" id="btPesquisar" value="Localizar" /></td>
        <td colspan="7" align="right"></td>
    </tr>-->
    <tr class="listaClara">
        <td><strong>Cód. </strong></td>
        <td><strong>Curso </strong></td>

        <td><strong>Local</strong></td>
        <td><strong> Data de Início</strong></td>
        <td><strong>Data de Término</strong></td>
        <td><strong>Horário</strong></td>
        <td align="center">Questionários</td>
      
        <td align="center">Alunos</td>
        
        <td width="169" align="center">Diário classe</td>
        <td width="143" align="center">Avaliação Final</td>
    
    </tr>

<?php
$cont = 0;

while ($row = mysql_fetch_array($rs)) {


    

    if ($cont === 0) {
        $linha = "listaClara";
        $cont = 1;
    } else {
        $linha = "listaEscura";
        $cont = 0;
    }
?>


    <tr class="<?php echo $linha ?>">
        <td width="20"><?php echo $row['id']?></td>
        <td width="442"><?php echo $row['nome']?></td>
        <td width="258"><?php echo $row['local'] ?></td>
        <td width="199"><?php echo data_br($row['dataInicio']) ?></td>
        <td width="199"><?php echo data_br($row['dataTermino']) ?></td>
        <td width="199">
        <?php echo $row['horario_inicial'] ?> às <?php echo $row['horario_final'] ?>
        </td>
        <td width="144" align="center">
            
            <?php if((int)$user->id===111) {?>
            
            <a href="pesquisaInfra.php?agenda=<?php echo $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">
            Alunos</a>
            &nbsp; | &nbsp;
           <?php } ?>
           <?php if((int)$user->id===111) {?>
            
            <a href="pesquisaProfessorCadastro.php?agenda=<?php echo $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">
            Monitor</a>
           <?php } ?>
        </td>
       
        <td width="144" align="center"><a href="alunosMatriculados.php?agenda=<?php echo $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>"><img src="../imagens/icon_alunos.png" width="20" height="20" border="0" /></a></td>
       
        <td align="center">
          <a href="principal.php?acao=diarios&agenda=<?php echo $row['id'] ?>"  id="<?php echo $row['id'] ?>">
            <img src="../imagens/icon_editar.gif" width="15" height="15" hspace="5" border="0" />
           </a>        </td>
        <td align="center"><a href="alunosAvaliacaoFinal.php?agenda=<?php echo $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>"><img src="../imagens/icon_avaliacao_final.png" width="22" height="22" border="0" /></a></td>
       
    </tr>
<?php } ?>


</table>
<p>
<?php
    @$paginas = $total / $limit;

    if ($paginas > 1) {
        echo "P&aacute;gina(s)";

        for ($i = 0; $i < $paginas; $i++) {

            $exibir = $i + 1;
            $start = $i * $limit;

            if (marcaPagina(@$_GET['offset'], $limit) == $i + 1) {
                printf('[<a href="%s&offset=%d" >%s</a>]', 'principal.php?acao=relatoriosClasses&busca=' . @$_GET['busca'], $start, $exibir);
            } else {
                printf('<a href="%s&offset=%d" >%s</a>', 'principal.php?acao=relatoriosClasses&busca=' . @$_GET['busca'], $start, $exibir);
            }
        }
    }
?>

</p>

<p>&nbsp;</p>
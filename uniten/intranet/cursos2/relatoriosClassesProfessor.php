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





                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Cursos</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="126">Curso</th>
                                                <th width="126">Local</th>
                                                <th width="30">Data início</th>
                                                <th width="30">Data término</th>
                                                <th width="30">Horário</th>
                                                <td width="30">Ações</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(mysql_num_rows($rs)>0){ ?>
                                        <?php while ($row = mysql_fetch_array($rs)) {?>
                                            <tr>
                                               <td><?php echo $row['nome']?></td>
                                                <td><?php echo $row['local'] ?></td>
                                                <td><?php echo data_br($row['dataInicio']) ?></td>
                                                <td><?php echo data_br($row['dataTermino']) ?></td>
                                                <td><?php echo $row['horario_inicial'] ?> às <?php echo $row['horario_final'] ?></td>
                                                <td>
                                                
                                                 <div class="btn-group">
                                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Selecione</button>
                                                  
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="principal.php?acao=diarios&agenda=<?php echo $row['id'] ?>"  id="<?php echo $row['id'] ?>">Diarios de classe</a></li>
                                                        <li><a href="principal.php?acao=alunosAvaliacaoFinal&agenda=<?php echo $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">Avaliação final</a></li>
                                                        <li><a href="principal.php?acao=alunosMatriculados&agenda=<?php echo $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">Alunos</a></li>
                                                        
                                                         <?php if((int)$user->id===225) {?>
                                                         <li class="divider"></li>
                                                         <li>
            												 <a href="pesquisaInfra.php?agenda=<?php echo $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">
                                                            Alunos</a>
                                                            &nbsp; | &nbsp;
                                                           <?php } ?>
                                                           <?php if((int)$user->id===225) {?>
                                                            
                                                            <a href="pesquisaProfessorCadastro.php?agenda=<?php echo $row['id'] ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">
                                                            Monitor</a>
                                                            </li>
                                                           <?php } ?>
                                                       
                                                    </ul>
                                       			 </div>
                                                
                                                </td>
                                            </tr>
                                             <?php } ?>  
                                            <?php }else{  ?>  
                                            <tr>
                                              <td colspan="7"><p class="text-red">Nenhum curso cadastrado</p></td>
                                            </tr>
                                            <?php } ?>
                                         
                                        </tbody>
                                        <!-- <tfoot>
                                            <tr>
                                                <th>Rendering engine</th>
                                                <th>Browser</th>
                                                <th>Platform(s)</th>
                                                <th>Engine version</th>
                                                <th>CSS grade</th>
                                            </tr>
                                        </tfoot> 
                                        -->
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                         
                        </div>
                    </div>

        

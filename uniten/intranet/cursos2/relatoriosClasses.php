<?php
require_once '../dao/pendenciaDao.php';
Security::cursoSecurity();
$cursos = new Curso();
$cursos->alias('c')->order('c.nome ASC')->find();
Security::cursoSecurity();
$obj = new AgendaCurso();


$locais = new Local();
$locais->alias('l')->where('l.ativo=1 and id in (select local_id from local_curso where empresa_curso_id = ?)',$user->empresa->id)->order('l.local ASC')->find();


$cpbusca = $obj->escape(@$_REQUEST['busca']);



if(!empty($_REQUEST['status'])){
	$status = (int)$_REQUEST['status'];	
	$titulo = "Finalizados";
}else{
   $status = 1;	
   $titulo = "Em andamento";
}




if((int)$user->tipoLogin == 2){
    
    gotox("principal.php?acao=relatoriosClassesProfessor");
    //var_dump($professor->_getLink('agendas'));
    //die;
}

if (empty($cpbusca)&& empty($_REQUEST['local'])) {

    $obj->alias('a')
            ->order('a.id DESC')
            ->where('a.status = '.$status.' and a.empresaCurso=?',$user->empresa->id)
            ->find();
} elseif(!empty($cpbusca)) {
    
    
     if ((int) $cpbusca > 0) {
        $where = 'a.id = ' . $cpbusca.' and a.empresaCurso='.$user->empresa->id;
        $obj->alias('a')
                ->join($cursos, 'INNER', 'c', 'curso', 'id')
                ->where($where)
                ->selectAs()
                ->order('a.id DESC')
                ->find();
    } else {
        $obj->alias('a')
            ->join($cursos, 'INNER', 'c', 'curso', 'id', 'c.nome like ?', $cpbusca)
            ->where('a.status = '.$status.' and a.empresaCurso=?',$user->empresa->id)
            ->selectAs()
            ->order('a.id ASC')
            ->find();
    }
    
} elseif(!empty($_REQUEST['local'])) {
    
    $obj->alias('a')
            ->order('a.id DESC')
            ->where('a.status = ? and a.local = ? and a.empresaCurso=?',$_REQUEST['status'],$_REQUEST['local'],$user->empresa->id)
            ->find();
}


$total = $obj->count();

$offset = sprintf('%d', empty($_GET['offset']) ? 0 : $_GET['offset']);
$obj->limit($offset, @$limit)
        ->find();

logDao::gravaLog($user->login, 'relatoriosClasses', 'Acessou: lista de relatorios de classe',$_REQUEST,'','Status: '.$titulo);




?>
<script src="scripts/relatoriosClasses.js"></script>
<div class="row">
                       
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Cursos</h3>
                                   
                                </div>
                                <div class="box-body">
                                 <table width="100%" border="0">
                                  <tr>
                                    <td>
                                       Status:
              
               <div class="form-group">
                                          <select class="form-control" style="width:150px" onchange="self.location='principal.php?acao=relatoriosClasses&status='+this.value" id="status">
                  <option value="1" <?php if($status===1) { ?>selected="selected" <?php } ?>>Andamento</option>
                  <option value="2" <?php if($status===2) { ?>selected="selected" <?php } ?>>Finalizados</option>
              </select>
              
           </div>
           
           
                                    </td>
                                    <td> 
                                    <button class="btn btn-success btn-flat" onclick="self.location='xls_relatorios.php?status=<?php echo $status?>'">Exportar</button>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><hr /></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    
                                    <td>
                                    Pesquisa(Curso/Cód)
                                     <div class="input-group input-group-sm" style="width:150px">
                                        <input class="form-control" name="busca" id="busca" type="text" value="<?php echo @$_REQUEST['busca']; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-flat" type="button" id="btPesquisar">Pesquisar!</button>
                                        </span>
                                    </div>
                                    
                                     
                                    
                                   
          							</td>
          <td><strong> Local</strong>:
           
                                   
                                   
                                     <div class="form-group">
                                       <select name="local" id="cbLocal" onchange="self.location='principal.php?acao=relatoriosClasses&local='+this.value+'&status='+document.getElementById('status').value" style="width:150px" class="form-control">
              <option value="">Todos</option>
              <?php echo Lumine_Util::buildOptions($locais,'id','local', @$_REQUEST['local']); ?>
          </select>
              
           </div>
                                   
                                    </td>
                                   
                                  </tr>
                                </table>

              
                              </div><!-- /.box-body -->
                               
                            </div><!-- /.box -->
                      
</div>


                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box"><!-- /.box-header -->
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
                                       
                                        <?php while ($obj->fetch()) {?>
                                            <tr>
                                                <td width="279"><?php echo $obj->curso->nome ?></td>
                                                <td width="214"><?php echo $obj->local->local ?></td>
                                                <td width="84"><?php echo data_br($obj->dataInicio) ?></td>
                                                <td width="67"><?php echo data_br($obj->dataTermino) ?></td>
                                                <td width="134"><?php echo $obj->horarioInicial ?> as <?php echo $obj->horarioFinal ?></td>
                                                <td width="166">
                                             
                                                
                                                 <div class="btn-group">
                                                    <button type="button" class="btn btn-default" data-toggle="dropdown">Selecione</button>
                                                   
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="principal.php?acao=diarios&agenda=<?php echo $obj->id  ?>"  id="<?php echo $obj->id  ?>">Diarios de classe</a></li>
                                                        <li><a href="principal.php?acao=alunosAvaliacaoFinal&agenda=<?php echo $obj->id  ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">Avaliação final</a></li>
                                                        <li><a href="principal.php?acao=alunosMatriculados&agenda=<?php echo $obj->id  ?>" class="cssAlunos" id="<?php echo $row['id'] ?>">Alunos</a></li>
                                                        
                                                        
                                                       
                                                    </ul>
                                       			 </div>
                                                
                                                </td>
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

        
